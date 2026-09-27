# KIEL INDUSTRIES — Site Laravel

## Démarrage

```bash
composer install   # si besoin
cp .env.example .env
php artisan key:generate
php artisan serve
```

Ouvrir http://127.0.0.1:8000

## Structure

- `resources/views/layouts/` — layout principal + header, footer, tiroirs
- `resources/views/pages/` — pages du site
- `public/assets/` — CSS, JS, images KIEL
- `routes/web.php` — routes nommées (`home`, `a-propos`, `boutique`, …)

La navigation est rendue côté serveur (Blade), plus de chargement `fetch` des partials.

## E-mails (contact, commandes, bienvenue)

En local avec [Maildev](https://github.com/maildev/maildev) :

```bash
maildev --web 1080 --smtp 1025
```

Dans `.env` : `MAIL_MAILER=smtp`, `MAIL_HOST=127.0.0.1`, `MAIL_PORT=1025`. Interface : http://127.0.0.1:1080

Vérifier l’envoi :

```bash
php artisan config:clear
php artisan kiel:mail-test
```

Les envois passent par `App\Support\KielMail` (SMTP synchrone, erreurs journalisées dans `storage/logs/laravel.log`).