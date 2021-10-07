<?php

/*
 * @copyright Deadan Group Limited
 * <code> Build something people want </code>
 */

namespace Deadan\Salami\Providers;

use Deadan\Salami\Plugins\SalamiPay;
use Deadan\Salami\Plugins\SalamiSms;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

/**
 * Class ModuleServiceProvider.
 */
class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            if ($this->app instanceof LumenApplication) {
                $this->app->configure('salami');
            } else {
                $this->publishes([
                    $this->getConfig() => config_path('salami.php'),
                ], 'config');
            }
        }

        $this->publishes([
            $this->getConfig() => config_path('salami.php'),
        ]);
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->getConfig(), 'salami');

        $this->app->bind('salami_pay', function ($app) {
            $salami = new SalamiPay(config('salami.pay_api_token'), config('salami.signature_verification'));

            return $salami->setAppId(config('salami.pay_app_id'));
        });

        $this->app->bind('salami_sms', function ($app) {
            $salami = new SalamiSms(config('salami.sms_api_token'), config('salami.signature_verification'));

            return $salami->setAppId(config('salami.sms_app_id'));
        });

        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * @return false|string
     */
    protected function getConfig()
    {
        return realpath(__DIR__.'/../../config/salami.php');
    }
}
