<?php namespace Langaner\RoutePriority;

use Illuminate\Support\ServiceProvider;

class RoutePriorityServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register any package services.
     *
     * @return void
     */
	public function register()
	{
		$this->app->singleton('router', function ($app) {
			return new \Langaner\RoutePriority\Router($app['events'], $app);
		});
	}

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['router'];
    }
}