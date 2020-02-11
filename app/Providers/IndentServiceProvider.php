<?php

namespace App\Providers;

use App\Models\IndentMaster;
use App\Observers\IndentObserver;
use Illuminate\Support\ServiceProvider;

class IndentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        IndentMaster::observe(IndentObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
