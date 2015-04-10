<?php

namespace EggDigital\Auth;

use Illuminate\Support\ServiceProvider;


class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('eggdigital/auth');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('CDNApiKey', 'EggDigital\Auth\Facades\CDNApiKey');
        });

        $this->app['auth\cdnapikey'] = $this->app->share(function($app)
        {
            return new Provider\CDNApiKeyProvider;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(
            'auth\cdnapikey',
        );
    }
}