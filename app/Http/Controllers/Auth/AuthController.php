<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeUser;
use App\Models\User;
use App\Support\KielMail;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laravel\Socialite\Contracts\Provider as SocialiteProvider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class AuthController extends Controller
{
    public function showLogin(Request $request): View
    {
        $this->rememberAuthRedirect($request);

        return view('pages.auth.login', ['page' => 'connexion', 'title' => 'Connexion']);
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->is_super_admin) {
                return redirect()->intended(route('admin.cms.dashboard'));
            }

            return redirect()->intended(route('account.dashboard'));
        }

        return back()->withErrors(['email' => 'Identifiants incorrects.'])->onlyInput('email');
    }

    public function showRegister(Request $request): View
    {
        $this->rememberAuthRedirect($request);

        return view('pages.auth.register', ['page' => 'inscription', 'title' => 'Inscription']);
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:40'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => $data['password'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        KielMail::send($user->email, new WelcomeUser($user));

        return redirect()->intended(route('account.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function redirectToGoogle(Request $request): RedirectResponse
    {
        if (! config('services.google.client_id')) {
            return redirect()->route('login')->withErrors(['email' => 'Connexion Google non configurée (GOOGLE_CLIENT_ID).']);
        }

        $request->session()->save();

        return $this->googleSocialite()->redirect();
    }

    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        if (! config('services.google.client_id')) {
            return redirect()->route('login')->withErrors(['email' => 'Connexion Google non configurée.']);
        }

        try {
            $googleUser = $this->googleSocialite()->user();
        } catch (InvalidStateException) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'La connexion Google a expiré (session perdue). Utilisez toujours la même adresse dans le navigateur (ex. localhost, pas 127.0.0.1), fermez les onglets en double, puis réessayez.',
                ]);
        }

        $user = User::query()->where('google_id', $googleUser->getId())->orWhere('email', $googleUser->getEmail())->first();

        $isNewUser = false;
        if ($user === null) {
            $isNewUser = true;
            $user = User::query()->create([
                'name' => $googleUser->getName() ?: 'Client KIEL',
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => Hash::make(Str::random(32)),
                'email_verified_at' => now(),
            ]);
        } else {
            $user->update([
                'google_id' => $googleUser->getId(),
                'name' => $user->name ?: ($googleUser->getName() ?: 'Client KIEL'),
            ]);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        if ($isNewUser) {
            KielMail::send($user->email, new WelcomeUser($user));
        }

        return redirect()->intended(
            $user->is_super_admin ? route('admin.cms.dashboard') : route('account.dashboard')
        );
    }

    public function showForgotPassword(Request $request): View
    {
        $this->rememberAuthRedirect($request);

        return view('pages.auth.forgot-password', ['page' => 'connexion', 'title' => 'Mot de passe oublié']);
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPassword(Request $request, string $token): View
    {
        return view('pages.auth.reset-password', [
            'page' => 'connexion',
            'title' => 'Réinitialiser le mot de passe',
            'token' => $token,
            'email' => $request->string('email')->toString(),
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    private function rememberAuthRedirect(Request $request): void
    {
        $redirect = $request->string('redirect')->toString();
        if ($redirect === '' || ! str_starts_with($redirect, url('/'))) {
            return;
        }

        session(['url.intended' => $redirect]);
    }

    private function googleSocialite(): SocialiteProvider
    {
        $driver = Socialite::driver('google')->redirectUrl(config('services.google.redirect'));

        if (config('services.google.stateless')) {
            $driver->stateless();
        }

        return $driver;
    }
}
