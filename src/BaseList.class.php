<?php

abstract class BaseList implements IteratorAggregate
{
	/**
	 * @var array
	 */
	protected $items;

	public function __construct($items = array())
	{
		$this->items = $items;
	}

	public function add($item)
	{
		$this->items[] = $item;
	}

	public function clear()
	{
		$this->items = array();
	}

	public function isEmpty()
	{
		return empty($this->items);
	}

	public function count()
	{
		return count($this->items);
	}

	public function first()
	{
		if (empty($this->items))
		{
			return null;
		}

		return reset($this->items);
	}

	public function getIterator()
	{
		return new ArrayIterator($this->items);
	}
}
 