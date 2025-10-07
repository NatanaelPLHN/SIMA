<?php

namespace App\Providers;

use App\Models\Departement;
use App\Observers\DepartementObserver;
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
        Departement::observe(DepartementObserver::class);
    }
}
