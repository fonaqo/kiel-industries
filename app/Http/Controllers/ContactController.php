<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmitted;
use App\Support\KielInbox;
use App\Support\KielMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'prenom' => ['required', 'string', 'max:80'],
            'nom' => ['required', 'string', 'max:80'],
            'email' => ['required', 'email', 'max:160'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ], [
            'prenom.required' => 'Indiquez votre prénom.',
            'nom.required' => 'Indiquez votre nom.',
            'email.required' => 'Indiquez votre adresse e-mail.',
            'email.email' => 'L’adresse e-mail n’est pas valide.',
            'message.required' => 'Écrivez votre message.',
            'message.min' => 'Votre message doit contenir au moins 10 caractères.',
        ]);

        $payload = [
            'prenom' => trim($data['prenom']),
            'nom' => trim($data['nom']),
            'email' => trim($data['email']),
            'message' => trim($data['message']),
        ];

        if (! KielMail::send(KielInbox::contactEmail(), new ContactFormSubmitted($payload))) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'L’envoi a échoué. Vérifiez que le serveur mail est disponible ou écrivez-nous directement à '.KielInbox::contactEmail().'.']);
        }

        return redirect()
            ->route('contact')
            ->with('contact_success', 'Merci ! Votre message a bien été envoyé. Notre équipe vous répondra sous 48 h ouvrées en moyenne.');
    }
}
