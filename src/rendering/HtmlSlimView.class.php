<?php

class HtmlSlimView extends \Slim\View
{
	/**
	 * @var $viewModel IViewModel
	 */
	protected $viewModel;

	/**
	 * @var IWebRequest
	 */
	protected $request;

	protected $blocks = array();

	/**
	 * @return array
	 */
	public function getAllFlashes()
	{
		return $_SESSION['slim.flash'];
	}

	public function hasFlash($key)
	{
		return isset($_SESSION['slim.flash'][$key]);
	}

	public function getFlash($key)
	{
		if (isset($_SESSION['slim.flash'][$key]))
		{
			return $_SESSION['slim.flash'][$key];
		}

		return '';
	}

	public function hasLayout()
	{
		return !is_null($this->viewModel->getLayout());
	}

	public function getModel()
	{
		return $this->viewModel;
	}

	public function render($template, $data = null)
	{
		$this->viewModel = $this->data['vm'];
		$this->request = @$this->data['request'];
		$this->renderModel($this->viewModel);

		if ($this->hasLayout())
		{
			$this->renderModel($this->viewModel->getLayout());
		}
	}

	protected function renderModel(IViewModel $model)
	{
		$slimView = $this;
		/** @noinspection PhpIncludeInspection */
		include($model->getTemplate());
		unset($slimView);
	}

	public function partial($template, array $data = array())
	{
		// define the variables for the view
		foreach ($data as $key => $val)
		{
			${$key} = $val;
		}

		// render the template
		ob_start();
		/** @noinspection PhpIncludeInspection */
		include($this->viewModel->getPartialsDir().'/'.$template.'.php');
		$html = ob_get_contents();
		ob_end_clean();

		// remove the variables we defined
		foreach ($data as $key => $val)
		{
			unset($key);
		}

		echo $html;
	}

	public function outputBlock($name)
	{
		if (!isset($this->blocks[$name]))
		{
			throw new Exception("The block '$name' does not exist");
		}

		$this->blocks[$name]();
	}

	public function outputOptionalBlock($name)
	{
		if (isset($this->blocks[$name]))
		{
			$this->blocks[$name]();
		}
	}

	public function setBlock($name, $function)
	{
		$this->blocks[$name] = $function;
	}

	public function setJsPage($jsPagePathRelativeToJsRoot)
	{
		$this->set('customslim-jspage', $jsPagePathRelativeToJsRoot);
	}

	public function getJsPage()
	{
		return $this->get('customslim-jspage');
	}

	/**
	 * Make a string cross-site-scripting
	 * safe to output
	 * @param $string String The string to make safe
	 * @return string
	 */
	public function safe($string)
	{
		return htmlspecialchars($string);
	}

	/**
	 * @return IWebRequest
	 */
	public function getRequest()
	{
		return $this->request;
	}
}
