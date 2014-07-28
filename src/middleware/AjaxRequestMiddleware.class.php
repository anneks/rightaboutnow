<?php

class AjaxRequestMiddleware extends \Slim\Middleware
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
		$request = $this->app->request;
		if ($request->isAjax() || $request->isXhr())
		{
			//
			// wrap ajax requests in a try...catch
			//
			try
			{
				$this->next->call();
			}
			catch (Exception $ex)
			{
				$response = $this->app->response;
				$vm = new AjaxViewModel();
				$vm->exception($ex);

				$this->app->render('', array('vm'=>$vm));
			}
		}
		else
		{
			//
			// leave non-ajax requests alone
			//
			$this->next->call();
		}
	}
}
