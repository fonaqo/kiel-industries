<?php

namespace App\Providers;

use App\Services\CmsSettings;
use App\Support\SeoResolver;
use App\View\Composers\SiteNavComposer;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Carbon::setLocale(config('app.locale'));
        Paginator::defaultView('pagination::kiel');

        try {
            $cms = app(CmsSettings::class);
            if ($social = $cms->get('social')) {
                config(['kiel.social' => $social]);
            }
            if ($shop = $cms->get('shop')) {
                config(['kiel.currency' => array_replace(config('kiel.currency', []), $shop)]);
            }
        } catch (\Throwable) {
            // Base de données indisponible (install, tests).
        }

        View::composer([
            'layouts.partials.site-header',
            'layouts.partials.site-header-mobile-nav-panel',
        ], SiteNavComposer::class);

        View::composer(['layouts.app', 'layouts.account', 'layouts.admin', 'layouts.cms-admin'], function ($view): void {
            $data = $view->getData();
            $existing = $data['seo'] ?? null;
            if (is_array($existing) && array_key_exists('title', $existing)) {
                return;
            }
            $view->with('seo', app(SeoResolver::class)->resolve($data));
        });
    }
}
