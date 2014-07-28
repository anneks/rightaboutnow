<?php

class AnnotationCollection
{
	/**
	 * @var Annotation[]
	 */
	private $items = array();

	public function add(Annotation $item)
	{
		$this->items[] = $item;
	}

	public function getAll()
	{
		return $this->items;
	}

	public function get($index)
	{
		if (isset($this->items[$index]))
		{
			return $this->items[$index];
		}

		return new NullAnnotation();
	}

	/**
	 * @return Annotation[]
	 */
	public function getWithName($name)
	{
		$result = array();

		foreach ($this->items as $item)
		{
			if ($item->getName() == $name)
			{
				$result[] = $item;
			}
		}

		return $result;
	}
}
