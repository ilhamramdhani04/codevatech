<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
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
        // ── HTTPS enforcement di production ─────────────────────────────
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // ── Rate Limiting ───────────────────────────────────────────────

        // Login: max 5 percobaan per menit per kombinasi email+IP
        RateLimiter::for('login', function (Request $request) {
            $key = strtolower($request->input('email', '')) . '|' . $request->ip();
            return Limit::perMinute(5)->by($key)
                        ->response(function () {
                            return back()->withErrors([
                                'email' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam 1 menit.',
                            ]);
                        });
        });

        // Diagnosis: max 10 request per menit per IP
        RateLimiter::for('diagnosis', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });

        // API/umum: max 60 request per menit per IP
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });
    }
}

