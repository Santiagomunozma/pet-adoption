<?php

namespace App\Providers;

use App\Services\PetImageStorage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PetImageStorage::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        if ($renderUrl = env('RENDER_EXTERNAL_URL')) {
            URL::forceRootUrl(rtrim($renderUrl, '/'));
        }
    }
}
