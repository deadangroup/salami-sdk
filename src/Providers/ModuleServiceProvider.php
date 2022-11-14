<?php

/*
 * @copyright Deadan Group Limited
 * <code> Build something people want </code>
 */

namespace DGL\Salami\Providers;

use dPOS\Admin\Commands\GenerateSitemap;
use dPOS\Admin\Commands\RefreshDemoBusiness;
use Illuminate\Support\ServiceProvider;

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
        $config = __DIR__.'/../../config/salami.php';

        $this->mergeConfigFrom($config, 'salami');

        $this->publishes([
            $config => config_path('salami.php'),
        ], 'config');
    }

    /**
     * Register the module services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register()
    {

    }
}
