<?php

class ObjectToArrayHelper
{
	/**
	 * @var ReflectionHelper
	 */
	private $reflectionHelper;

	public function __construct(ReflectionHelper $reflectionHelper)
	{
		$this->reflectionHelper = $reflectionHelper;
	}

	public function toArray($instance)
	{
		$ref = new ReflectionClass($instance);
		$fields = $ref->getProperties();

		$result = array();

		foreach ($fields as $field)
		{
			if ($this->reflectionHelper->hasAnnotation($field->getDocComment(), 'jsonIgnore'))
			{
				continue;
			}


			if ($this->reflectionHelper->hasAnnotation($field->getDocComment(), 'calculatedBy'))
			{
				$annotations = $this->reflectionHelper->getAnnotations($field->getDocComment());
				$calculatedByAnnotations = $annotations->getWithName('calculatedBy');
				$values = $calculatedByAnnotations[0]->getValues();
				$instance->{$values[0]}();
			}

			$field->setAccessible(true);
			$value = $field->getValue($instance);

			if (!is_null($value))
			{
				$result[$field->getName()] = $this->getValue($value);
			}
		}

		return $result;
	}

	private function getValue($value)
	{
		switch (gettype($value))
		{
			case 'object':
				return $this->toArray($value);

			case 'array':
				$result = array();
				if ($this->isArrayAssoc($value))
				{
					foreach ($value as $key => $val)
					{
						$result[$key] = $this->getValue($val);
					}
				}
				else
				{
					foreach ($value as $val)
					{
						$result[] = $this->getValue($val);
					}
				}
				return $result;

			case 'resource':
				return null;

			default:
				return $value;
		}
	}

	private function isArrayAssoc(array $array)
	{
		// originally from
		// http://stackoverflow.com/a/4254008
		return (bool)count(array_filter(array_keys($array), 'is_string'));
	}
}
