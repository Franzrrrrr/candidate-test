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

        // Use custom pagination view
        \Illuminate\Pagination\Paginator::defaultView('vendor.pagination.bootstrap-4');
        \Illuminate\Pagination\Paginator::defaultSimpleView('vendor.pagination.simple-bootstrap-4');
    }
}
