<?php

namespace App\Support;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class KielMail
{
    /**
     * Envoie un e-mail de façon synchrone via le mailer configuré (SMTP / Maildev).
     */
    public static function send(string $to, Mailable $mailable): bool
    {
        $to = trim($to);
        if ($to === '' || ! filter_var($to, FILTER_VALIDATE_EMAIL)) {
            Log::warning('Email delivery skipped: invalid recipient', [
                'to' => $to,
                'mailable' => $mailable::class,
            ]);

            return false;
        }

        try {
            Mail::mailer(config('mail.default'))->to($to)->send($mailable);

            return true;
        } catch (Throwable $e) {
            Log::error('Email delivery failed', [
                'to' => $to,
                'mailable' => $mailable::class,
                'mailer' => config('mail.default'),
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /** Envoie l’e-mail après la réponse HTTP (checkout non bloqué par SMTP). */
    public static function sendAfterResponse(string $to, Mailable $mailable): void
    {
        $to = trim($to);
        if ($to === '' || ! filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        dispatch(static function () use ($to, $mailable): void {
            self::send($to, $mailable);
        })->afterResponse();
    }
}
