<?php namespace Langaner\RoutePriority;

trait RouterTrait 
{
	/**
	 * Get the route dispatcher callback.
	 *
	 * @return \Closure
	 */
	protected function dispatchToRouter()
	{
		$this->router = $this->app['router'];
		
		if(!empty($this->middlewareGroups)) {
			foreach ($this->middlewareGroups as $key => $middleware) {
				$this->router->middlewareGroup($key, $middleware);
			}
		}		
		
		if(!empty($this->routeMiddleware)) {
			foreach ($this->routeMiddleware as $key => $middleware) {
				$this->router->aliasMiddleware($key, $middleware);
			}
		}

		return parent::dispatchToRouter();
	}
}
