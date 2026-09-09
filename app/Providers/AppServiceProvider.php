<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Throwable;

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
        Http::macro('sso', function () {
            return Http::baseUrl(rtrim((string) config('services.sso.url'), '/'))
                ->acceptJson()
                ->asJson()
                ->timeout((int) config('services.sso.timeout'))
                ->connectTimeout(3)
                ->retry(2, 100, fn (Throwable $exception): bool => $exception instanceof ConnectionException);
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->string('email')->lower();

            return Limit::perMinute(5)->by($email.'|'.$request->ip());
        });
    }
}
