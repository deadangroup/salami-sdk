<?php

namespace Deadan\Salami;

use Deadan\Salami\Plugins\SalamiPay;
use Deadan\Salami\Plugins\SalamiSms;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

class SalamiServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            if ($this->app instanceof LumenApplication) {
                $this->app->configure('salami');
            } else {
                $this->publishes([
                    $this->getConfigFile() => config_path('salami.php'),
                ], 'config');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->mergeConfigFrom($this->getConfigFile(), 'salami');

        $this->app->bind('salami_pay', function ($app) {
            $salami = new SalamiPay(config('salami.pay_api_token'), config('salami.signature_verification'));

            return $salami;
        });

        $this->app->bind('salami_sms', function ($app) {
            $salami = new SalamiSms(config('salami.sms_api_token'), config('salami.signature_verification'));

            return $salami;
        });
    }

    /**
     * @return string
     */
    protected function getConfigFile()
    : string
    {
        return __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'salami.php';
    }
}
