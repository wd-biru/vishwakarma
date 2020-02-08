<?php

namespace App\Providers;

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
