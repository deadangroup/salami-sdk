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
use Deadan\Support\Console\InstallCommand;
use Deadan\Support\Console\UpgradeTimestamps;
use Deadan\Support\Validation\CustomReplacer;
use Deadan\Support\Validation\CustomValidationRules;
use Deadan\Support\Validation\PhoneNumberRegexRule;
use Illuminate\Database\Schema\Blueprint;
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
        $this->hookBcAliases();
        $this->registerMigrationMacros();

        $this->commands([
            DetectEnvVariables::class,
            InstallCommand::class,
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

    /*
     * Some external packages have hardcoded App/User and App\Http\Controllers\Controller.
     *
     * We will alias them here for compatibility.
     */

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

    public function hookBcAliases()
    {
        class_alias(config('auth.providers.users.model'), 'App\User');
//        class_alias('App\Http\Controllers\Controller', 'App\Http\Controllers\Controller');
    }

    public function registerMigrationMacros()
    {
        Blueprint::macro('hasUuid', function () {
            $this->uuid('uuid')->nullable(true);
        });
        Blueprint::macro('dropHasUuid', function () {
            $this->dropColumn(['uuid']);
        });
    }
}
