<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;

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
        $this->rateLimiter();
    }
    protected function rateLimiter()
    {
        RateLimiter::for('register', function (Request $request) {
            return Limit::perHour(7)->by($request->user()?->id ?: $request->ip())->response(function () {
                return apiResponse(429, 'Try again After 60 munites');
            });
        });
        RateLimiter::for('login', function (Request $request) {
            return Limit::perHour(7)->by($request->user()?->id ?: $request->ip())->response(function () {
                return apiResponse(429, 'Try again After 60 munites');
            });
        });
        RateLimiter::for('loans', function (Request $request) {
            return Limit::perHour(3)->by($request->user()?->id ?: $request->ip())->response(function () {
                return apiResponse(429, 'Try again After 60 munites');
            });
        });
    }
}
