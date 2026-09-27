<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function __invoke(): Response
    {
        $sitemap = url('/sitemap.xml');

        $body = implode("\n", [
            'User-agent: *',
            'Allow: /',
            'Disallow: /mon-compte',
            'Disallow: /admin',
            'Disallow: /connexion',
            'Disallow: /inscription',
            'Disallow: /cart',
            'Disallow: /commande',
            'Disallow: /deconnexion',
            'Disallow: /auth/',
            '',
            'User-agent: GPTBot',
            'Allow: /',
            'Disallow: /mon-compte',
            'Disallow: /admin',
            '',
            'User-agent: Google-Extended',
            'Allow: /',
            '',
            'User-agent: anthropic-ai',
            'Allow: /',
            '',
            'User-agent: ClaudeBot',
            'Allow: /',
            '',
            "Sitemap: {$sitemap}",
            '',
        ]);

        return response($body, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
