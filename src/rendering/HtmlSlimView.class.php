<?php

class HtmlSlimView extends \Slim\View
{
	/**
	 * @var $viewModel IViewModel
	 */
	protected $viewModel;

	protected $blocks = array();

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
		$this->renderModel($this->viewModel);

		if ($this->hasLayout())
		{
			$this->renderModel($this->viewModel->getLayout());
		}
	}

	protected function renderModel(IViewModel $model)
	{
		/** @noinspection PhpIncludeInspection */
		include($model->getTemplate());
	}

	public function outputBlock($name)
	{
		if (!isset($this->blocks[$name]))
		{
			throw new Exception("The block '$name' does not exist");
		}

		$this->blocks[$name]();
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
}
