<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class RouteServiceProvider extends ServiceProvider
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
        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)  // Make sure the namespace is applied correctly
                ->group(base_path('routes/api.php'));
    
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }
}
