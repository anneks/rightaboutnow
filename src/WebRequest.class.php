<?php

class WebRequest implements IWebRequest
{
	/**
	 * @var Slim\Http\Request
	 */
	private $slimRequest;

	private $routeParams = array();

	public function __construct(\Slim\Http\Request $slimRequest)
	{
		$this->slimRequest = $slimRequest;
	}

	public function setRouteParam($key, $val)
	{
		$this->routeParams[$key] = $val;
	}

	function get($key, $default = null)
	{
		return $this->slimRequest->get($key, $default);
	}

	function post($key, $default = null)
	{
		return $this->slimRequest->post($key, $default);
	}

	function routeParam($key, $default = null)
	{
		if (isset($this->routeParams[$key]))
		{
			return $this->routeParams[$key];
		}

		return $default;
	}

	function path()
	{
		return $this->slimRequest->getPath();
	}
}
