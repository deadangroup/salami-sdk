<?php

/*
 * @copyright Deadan Group Limited
 * <code> Build something people want </code>
 */

namespace DGL\Salami\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ModuleServiceProvider.
 */
class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register the module services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register()
    {
        $config = __DIR__.'/../../config/salami.php';

        $this->mergeConfigFrom($config, 'salami');

        $this->publishes([
            $config => config_path('salami.php'),
        ], 'config');
    }
}
