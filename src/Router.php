<?php namespace Langaner\RoutePriority;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Router as IlluminateRouter;

class Router extends IlluminateRouter
{
	/**
	 * @var string
	 */
	const DEFAULT_PRIORITY = 50;

	/**
	 * Create a new Router instance.
	 *
	 * @param  Dispatcher  $events
	 * @param  Container  $container
	 * @return void
	 */
	public function __construct(Dispatcher $events, Container $container = null)
	{
		parent::__construct($events, $container);
		$this->routes = new RouteCollection;
	}

	/**
	 * Create a new Route object.
	 *
	 * @param  array|string  $methods
	 * @param  string  $uri
	 * @param  mixed   $action
	 * @return \Illuminate\Routing\Route
	 */
	protected function newRoute($methods, $uri, $action)
	{
		$route = (new Route($methods, $uri, $action))->setContainer($this->container);
		$priority = self::DEFAULT_PRIORITY - $this->routes->count();
		$route->setPriority($priority);

		return $route;
	}

	/**
     * Create a new route instance.
     *
     * @param  array|string  $methods
     * @param  string  $uri
     * @param  mixed   $action
     * @return \Illuminate\Routing\Route
     */
    protected function createRoute($methods, $uri, $action)
    {
        $route = parent::createRoute($methods, $uri, $action);
		if (!empty($this->groupStack)) {
			$route = $this->mergePriority($route);
		}
		
		return $route;
    }

    protected function mergePriority($route)
	{
		$row = last($this->groupStack);
		if (isset($row['priority'])) {
			$route->setPriority($row['priority']);
		}

		return $route;
	}

	/**
     * Dispatch the request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dispatch(Request $request)
    {
        $this->getRoutes();
        
		return parent::dispatch($request);
    }

     /**
     * Get the underlying route collection.
     *
     * @return \Illuminate\Routing\RouteCollection
     */
    public function getRoutes()
    {
        $routes = parent::getRoutes();
		$routes->buildRoutesOrder();
		
		return $routes;
    }
}