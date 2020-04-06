<?php
/* CLC Project version 6.0
 * EducationDataService version 6.0
 * Adam Bender and Jim Nguyen
 * April 5, 2020
 * LoggingServiceProvider
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Utility\MyLogger3;

class LoggingServiceProvider extends ServiceProvider
{
    protected $defer = true;
    
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Services\Utility\ILoggerService', function ($app){
            return new MyLogger3();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    
    public function provides()
    {
        return ['App\Services\Utility\ILoggerService'];
    }
}
