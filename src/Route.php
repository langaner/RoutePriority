<?php namespace Langaner\RoutePriority;

use Illuminate\Routing\Route as IlluminateRoute;
use Illuminate\Http\Request;
use Illuminate\Routing\ControllerDispatcher;

class Route extends IlluminateRoute
{
	/**
	 * @var int
	 */
	protected $priority = Router::DEFAULT_PRIORITY;

	/**
     * Run the route action and return the response.
     *
     * @return mixed
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function runController()
    {
    	$this->router = app('router');
        list($class) = explode('@', $this->action['uses']);

        $this->controller = $this->container->make($class);
        
        return (new ControllerDispatcher($this->container))->dispatch(
            $this, $this->controller, $this->getControllerMethod()
        );
    }
	
	/**
	 * @return int
	 */
	public function getPriority()
	{
		return $this->priority;
	}

	/**
	 * @param int $priority
	 */
	public function setPriority($priority)
	{
		$this->priority = $priority;
	}
}