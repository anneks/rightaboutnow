<?php

class SlimViewFactory
{
	/**
	 * @var Container
	 */
	private $container;

	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	public function getHtmlSlimView()
	{
		return $this->container->getHtmlSlimView();
	}

	public function getJsonSlimView()
	{
		return $this->container->getJsonSlimView();
	}
}
 