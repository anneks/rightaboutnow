<?php

class WebResponse implements IWebResponse
{
	/**
	 * @var Slim\Http\Response
	 */
	private $slimResponse;
	/**
	 * @var Slim\Slim
	 */
	private $slimApp;

	public function __construct(\Slim\Http\Response $slimResponse, \Slim\Slim $slimApp)
	{
		$this->slimResponse = $slimResponse;
		$this->slimApp = $slimApp;
	}

	function redirect($url)
	{
		$this->slimApp->redirect($url);
	}
}
