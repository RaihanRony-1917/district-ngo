<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
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
        // Schema::defaultStringLength(191);
        if (config('app.env') !== 'local') {
            Request::setTrustedProxies(
                   ['0.0.0.0/0'],
                Request::HEADER_X_FORWARDED_AWS_ELB
            );
            URL::forceScheme('https');
        }
    }
}
