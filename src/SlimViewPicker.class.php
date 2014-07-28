<?php

class SlimViewPicker
{
	/**
	 * @var Slim\Slim
	 */
	private $app;
	/**
	 * @var SlimViewFactory
	 */
	private $slimViewFactory;

	public function __construct(\Slim\Slim $app, SlimViewFactory $slimViewFactory)
	{
		$this->app = $app;
		$this->slimViewFactory = $slimViewFactory;
	}

	public function getSlimView(\Slim\Http\Request $request)
	{
		if ($request->isAjax() || $request->isXhr() || $request->get('format','') == 'json' || $request->post('format','') == 'json')
		{
			return $this->slimViewFactory->getJsonSlimView();
		}

		return $this->slimViewFactory->getHtmlSlimView();
	}
}
