<?php

namespace App\Providers;

use App\Models\Departement;
use App\Models\Institution;
use App\Observers\DepartementObserver;
use App\Observers\InstitutionObserver;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use App\Http\View\Composers\NotificationComposer;

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
        Institution::observe(InstitutionObserver::class);
        View::composer('layouts.header', NotificationComposer::class);
    }
}
