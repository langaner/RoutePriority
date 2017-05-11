<?php namespace Langaner\RoutePriority;

use Illuminate\Routing\RouteCollection as IlluminateRouteCollection;

class RouteCollection extends IlluminateRouteCollection
{
	/**
	 * @var \Closure
	 */
	protected $comparePriority;

	public function __construct()
	{
		$this->comparePriority = function($r1, $r2)
		{
			$a = $r1->getPriority();
			$b = $r2->getPriority();

			if ($a == $b) {
				return 0;
			}

			return ($a < $b) ? 1 : -1;
		};
	}

	/**
	 * Add the given route to the arrays of routes.
	 *
	 * @param  \Illuminate\Routing\Route $route
	 * @return void
	 */
	protected function addToCollections($route)
	{
		$domainAndUri = $route->domain().$route->uri().$route->getPriority();

		foreach ($route->methods() as $method) {
			$this->routes[$method][$domainAndUri] = $route;
		}

		$this->allRoutes[$method.$domainAndUri] = $route;
	}

	public function buildRoutesOrder()
	{
		uasort($this->allRoutes, $this->comparePriority);
		foreach ($this->routes as $method => $_tmp) {
			uasort($this->routes[$method], $this->comparePriority);
		}
	}
} 