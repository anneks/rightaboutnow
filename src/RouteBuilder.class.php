<?php

class RouteBuilder
{
	private $method;
	private $route;
	private $controllerName;
	private $params = array();
	private $middleware = array();

	public function getMethod()
	{
		return $this->method;
	}

	public function setMethod($method)
	{
		$this->method = $method;
	}

	public function getRoute()
	{
		return $this->route;
	}

	public function setRoute($route)
	{
		$this->route = $route;
	}

	public function getControllerName()
	{
		return $this->controllerName;
	}

	public function setControllerName($controllerName)
	{
		$this->controllerName = $controllerName;
	}

	public function getParams()
	{
		return $this->params;
	}

	public function addParam($param)
	{
		$this->params[] = $param;
	}

	public function addMiddleware($middleware)
	{
		$this->middleware[] = $middleware;
	}


	private static $template = <<<EOF
\$this->app->{METHOD}('{ROUTE}',{MIDDLEWARE} function({PARAMS}) use (\$app, \$container) {
	\$request = \$container->getIWebRequest(\$app->request);
	\$response = \$container->getIWebResponse(\$app->response, \$app);

	{SETPARAMS}

	\$controller = \$container->get{CONTROLLER}();
	\$viewModel = \$controller->execute(\$request, \$response);
	\$app->render('', array('vm'=>\$viewModel, 'request'=>\$request));
});
EOF;


	public function render()
	{
		$code = self::$template;

		$code = str_replace('{METHOD}', $this->method, $code);
		$code = str_replace('{ROUTE}', $this->route, $code);
		$code = str_replace('{MIDDLEWARE}', $this->getMiddleware(), $code);
		$code = str_replace('{PARAMS}', $this->getParamsAsParameterList(), $code);
		$code = str_replace('{SETPARAMS}', $this->getParamSettingCode(), $code);
		$code = str_replace('{CONTROLLER}', $this->controllerName, $code);

		return $code;
	}

	private function getParamsAsParameterList()
	{
		$x = array();

		foreach ($this->params as $p)
		{
			$x[] = "\$$p";
		}

		return implode(', ', $x);
	}

	private function getParamSettingCode()
	{
		$x = array();

		foreach ($this->params as $p)
		{
			$x[] = "\$request->setRouteParam('$p', \$$p);";
		}

		return implode("\n", $x);
	}

	private function getMiddleware()
	{
		$code = '';
		foreach ($this->middleware as $middlewareClass)
		{
			$code .= <<<EOF
function(\Slim\Route \$route) use (\$app, \$container) {
	\$x = \$container->get{$middlewareClass}();
	\$x->execute(\$route, \$app);
},
EOF;
		}

		return $code;
	}
}
