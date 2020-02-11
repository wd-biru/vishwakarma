<?php

namespace App\Providers;

use App\Models\IndentMaster;
use App\Observers\IndentObserver;
use Illuminate\Support\ServiceProvider;
use Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('date', function ($expression) {
            // dd($expression);
           return "<?php echo date('d/m/Y',strtotime($expression)); ?>";
        });
        Blade::directive('datetime', function ($expression) {
           return "<?php  echo date('d/m/Y H:i:s',strtotime($expression)); ?>";
        });
        Blade::directive('time', function ($expression) {
           return "<?php  echo date('H:i:s',strtotime($expression)); ?>";
        });


        IndentMaster::observe(IndentObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
