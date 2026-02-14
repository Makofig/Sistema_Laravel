<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter; 
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
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
        //
        Schema::defaultStringLength(191);
            // RateLimiter::for('api', function (Request $request) {
            //     return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
            // });
        RateLimiter::for('api', function (Request $request){
            return Limit::perMinute(5)->by($request->ip()); 
        }); 

        RateLimiter::for('auth-users', function (Request $request){
            return Limit::perMinute(120)->by(
                optional($request->user())->id ?: $request->ip()
            );
        });

        RateLimiter::for('stats-heavy', function (Request $request){
            return Limit::perMinute(10)->by(
                optional($request->user())->id ?: $request->ip()
            )->response(function () {
                return response()->json([
                    'message' => 'Too many requests. Please try again later.'
                ], 429);
            });
        }); 
    }
}
