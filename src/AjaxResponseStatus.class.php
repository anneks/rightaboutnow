<?php

class AjaxResponseStatus
{
	protected $message = '';
	/**
	 * @var array()
	 */
	protected $errors = array();
	protected $stackTrace = '';

	public function setMessage($x)
	{
		$this->message = $x;
	}

	public function getMessage()
	{
		return $this->message;
	}

	public function getErrors()
	{
		return $this->errors;
	}

	public function addError($error)
	{
		$this->errors[] = $error;
	}

	public function setStackTrace($stackTrace)
	{
		$this->stackTrace = $stackTrace;
	}

	public function populateFromException(Exception $ex)
	{
		$this->setMessage($ex->getMessage());
		$this->setStackTrace($ex->getTraceAsString());
	}
}
