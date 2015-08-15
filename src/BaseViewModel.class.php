<?php

abstract class BaseViewModel implements IViewModel
{
	/**
	 * @var IViewModel
	 * @jsonIgnore
	 */
	protected $layoutModel;

	/**
	 * @jsonIgnore
	 */
	protected $templateName = null;

	public function getLayout()
	{
		return $this->layoutModel;
	}

	public function getTemplateName()
	{
		if (is_null($this->templateName))
		{
			return str_replace('ViewModel', '', get_class($this));
		}

		return $this->templateName;
	}

	public function getTemplate()
	{
		return INC.'/templates/'.$this->getTemplateName().'.php';
	}

	public function getPartialsDir()
	{
		return INC.'/templates/partials';
	}

	public function setTemplateName($templateName)
	{
		$this->templateName = $templateName;
	}
}
