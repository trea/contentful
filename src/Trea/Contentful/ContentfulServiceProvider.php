<?php namespace Trea\Contentful;

use Illuminate\Support\ServiceProvider;

class ContentfulServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function boot()
    {
        $this->package('trea/contentful');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->package('trea/contentful');
        

        $this->app['contentful'] = $this->app->share(function ($app) {
            $config = $app->make('config');
            $cache = $app->make('cache');

            return new Contentful(
                $config->get('contentful::API_BASE', 'https://cdn.contentful.com'),
                $config->get('contentful::SPACE_KEY'),
                $config->get('contentful::ACCESS_TOKEN'),
                $cache
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
