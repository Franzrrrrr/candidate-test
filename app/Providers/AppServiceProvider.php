<?php

namespace App\Providers;

use App\Models\Supplier;
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
        Supplier::observe(\App\Observers\SupplierObserver::class);
    }
}
