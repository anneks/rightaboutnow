<?php

class AjaxViewModel extends BaseViewModel
{
	/**
	 * @var AjaxResponseStatus
	 */
	protected $responseStatus;

	public function setStatusMessage($message)
	{
		$this->ensureResponseStatus();
		$this->responseStatus->setMessage($message);
	}

	public function addResponseError($error)
	{
		$this->ensureResponseStatus();
		$this->responseStatus->addError($error);
	}

	protected function ensureResponseStatus()
	{
		if (is_null($this->responseStatus))
		{
			$this->responseStatus = new AjaxResponseStatus();
		}
	}

	public function exception(Exception $ex)
	{
		$this->ensureResponseStatus();
		$this->responseStatus->populateFromException($ex);
	}
} 
