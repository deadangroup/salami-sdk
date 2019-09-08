<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Providers;

use Deadan\Support\Console\DetectEnvVariables;
use Deadan\Support\Console\UpgradeTimestamps;
use Deadan\Support\Log\SmsLogger;
use Deadan\Support\Log\SmsLogHandler;
use Deadan\Support\Validation\CustomReplacer;
use Deadan\Support\Validation\CustomValidationRules;
use Deadan\Support\Validation\PhoneNumberRegexRule;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Log\LogManager;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Validation\Rule;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerValidationRules();
        $this->registerMigrationMacros();
        $this->registerSmsProvider();
        $this->registerSmsLogger();

        $this->commands([
            DetectEnvVariables::class,
            UpgradeTimestamps::class,
        ]);
    }

    /**
     *
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/deadan_support.php', 'deadan_support');

        $this->publishes([
            __DIR__ . '/../../config/deadan_support.php' => config_path('deadan_support.php'),
        ]);
    }

    /**
     * Register the "phonenumberRegex" rule macro.
     */
    protected function registerValidationRules()
    {
        if (class_exists('Illuminate\Validation\Rule') && class_uses(Rule::class, Macroable::class)) {
            Rule::macro('phonenumberRegex', function () {
                return new PhoneNumberRegexRule();
            });
        }

        //make sure array validation errors are shown in a better way
        Validator::resolver(function ($translator, $data, $rules, $messages, $attributes) {
            return new CustomReplacer($translator, $data, $rules, $messages, $attributes);
        });

        Validator::extend('old_password', CustomValidationRules::class . '@validateOldPassword');
        Validator::extend('excel_columns', CustomValidationRules::class . '@validateExcelColumns');
    }

    /**
     *
     */
    public function registerMigrationMacros()
    {
        Blueprint::macro('hasUuid', function () {
            $this->uuid('uuid')->nullable(true);
        });
        Blueprint::macro('dropHasUuid', function () {
            $this->dropColumn(['uuid']);
        });
    }

    /**
     * Register the service provider.
     */
    public function registerSmsProvider()
    {
        $this->app->singleton('deadan_sms', function ($app) {
            $config = config('deadan_support.sms');

            $factory = with(new \Deadan\Support\Sms\Factory())
                ->withConfig($config);
//                ->withLogger(app(\Psr\Log\LoggerInterface::class));

            return $factory;
        });
    }

    /**
     * Sends log files to sms.
     */
    public function registerSmsLogger()
    {
        if ($this->app['log'] instanceof LogManager) {

            $this->app['log']->extend('deadan_sms', function (Container $app, array $config) {
                $logger = new SmsLogger();

                return $logger($config);
            });
        }
    }
}
