<?php

namespace DehaSoft\LaravelGmoPayment;

use DehaSoft\LaravelGmoPayment\Facades\GMO as GMOFacade;
use DehaSoft\LaravelGmoPayment\GMO;
use Illuminate\Support\ServiceProvider;

class GMOPaymentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/gmo.php' => config_path('permission.php'),
        ], 'gmo');

        $this->app->bind('gmo', function ($app) {
            return new GMO($app);
        });
        $this->registerFacade();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/gmo.php',
            'gmo'
        );
    }

    /**
     * Register facade
     *
     * @return void
     */
    public function registerFacade()
    {
        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('gmo', GMOFacade::class);
        });
    }
}
