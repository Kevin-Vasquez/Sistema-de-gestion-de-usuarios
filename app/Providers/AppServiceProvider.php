<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//añadimos la libreria necesaria
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //añadiendo el uso de bootstrap a la tabla
        Paginator::useBootstrap();
    }
}
