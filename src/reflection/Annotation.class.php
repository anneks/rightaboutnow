<?php

class Annotation
{
	private $name;
	private $values = array();

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getValues()
	{
		return $this->values;
	}

	public function addValue($value)
	{
		$this->values[] = $value;
	}

	public function hasValues()
	{
		return !empty($this->values);
	}

	public function isNull()
	{
		return false;
	}
}
