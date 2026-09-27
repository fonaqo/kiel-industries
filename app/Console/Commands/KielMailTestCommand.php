<?php

namespace App\Console\Commands;

use App\Mail\ContactFormSubmitted;
use App\Support\KielInbox;
use App\Support\KielMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class KielMailTestCommand extends Command
{
    protected $signature = 'kiel:mail-test {--to= : Adresse de test (défaut : boîte KIEL)}';

    protected $description = 'Vérifie la configuration SMTP et envoie un e-mail de test';

    public function handle(): int
    {
        $to = $this->option('to') ?: KielInbox::contactEmail();

        $this->line('Mailer : '.config('mail.default'));
        $this->line('SMTP : '.config('mail.mailers.smtp.host').':'.config('mail.mailers.smtp.port'));
        $this->line('From : '.config('mail.from.address'));
        $this->line('Destinataire test : '.$to);

        try {
            Mail::raw('Test SMTP KIEL INDUSTRIES — '.now()->toDateTimeString(), function ($message) use ($to) {
                $message->to($to)->subject('[KIEL] Test SMTP');
            });
            $this->info('E-mail brut envoyé.');
        } catch (\Throwable $e) {
            $this->error('Échec SMTP : '.$e->getMessage());
            $this->line('Assurez-vous que Maildev tourne (ex. `maildev --web 1080 --smtp 1025`) ou configurez un vrai SMTP.');

            return self::FAILURE;
        }

        $payload = [
            'prenom' => 'Test',
            'nom' => 'CLI',
            'email' => 'test-cli@example.com',
            'message' => 'Message généré par php artisan kiel:mail-test.',
        ];

        if (KielMail::send($to, new ContactFormSubmitted($payload))) {
            $this->info('Mailable contact (template) envoyé.');

            return self::SUCCESS;
        }

        $this->error('Le mailable contact a échoué (voir storage/logs).');

        return self::FAILURE;
    }
}
