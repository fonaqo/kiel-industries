<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => (function (): string {
            $configured = trim((string) env('GOOGLE_REDIRECT_URI', ''));
            if ($configured !== '' && ! str_contains($configured, '${')) {
                return $configured;
            }

            return rtrim((string) env('APP_URL', 'http://localhost'), '/').'/auth/google/callback';
        })(),
        // En local, la session peut ne pas survivre au aller-retour Google (InvalidStateException).
        'stateless' => filter_var(
            env('GOOGLE_OAUTH_STATELESS', env('APP_ENV') === 'local'),
            FILTER_VALIDATE_BOOL
        ),
    ],

];
