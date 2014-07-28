<?php

class ViewPickerMiddleware extends \Slim\Middleware
{
	/**
	 * @var SlimViewPicker
	 */
	private $viewPicker;

	public function __construct(SlimViewPicker $viewPicker)
	{
		$this->viewPicker = $viewPicker;
	}

	/**
	 * Call
	 *
	 * Perform actions specific to this middleware and optionally
	 * call the next downstream middleware.
	 */
	public function call()
	{
		$view = $this->viewPicker->getSlimView($this->app->request);
		$this->app->view = $view;

		if (!is_null($this->next))
		{
			$this->next->call();
		}
	}
}
