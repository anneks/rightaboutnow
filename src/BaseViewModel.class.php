<?php

abstract class BaseViewModel implements IViewModel
{
	/**
	 * @var IViewModel
	 * @jsonIgnore
	 */
	protected $layoutModel;

	public function getLayout()
	{
		return $this->layoutModel;
	}

	public function getTemplate()
	{
		return INC.'/templates/'.str_replace('ViewModel', '', get_class($this)).'.php';
	}

	public function getPartialsDir()
	{
		return INC.'/templates/partials';
	}
}
