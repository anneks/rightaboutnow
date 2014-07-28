<?php

class JsonSlimView extends \Slim\View
{
	/**
	 * @var $viewModel IViewModel
	 */
	protected $viewModel;
	/**
	 * @var ObjectToArrayHelper
	 */
	private $objectToArrayHelper;

	public function __construct(ObjectToArrayHelper $objectToArrayHelper)
	{
		parent::__construct();
		$this->objectToArrayHelper = $objectToArrayHelper;
	}

	public function render($template, $data = null)
	{
		$this->viewModel = $this->data['vm'];

		$data = $this->objectToArrayHelper->toArray($this->viewModel);

		print (json_encode(
			  $data
			,   JSON_HEX_QUOT
			  | JSON_BIGINT_AS_STRING
			  | JSON_UNESCAPED_SLASHES
			  | JSON_PRETTY_PRINT
		));
	}
}
