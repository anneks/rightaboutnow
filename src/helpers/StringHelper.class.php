<?php

class StringHelper
{
	public function startsWith($subject, $needle)
	{
		return strpos($subject, $needle) === 0;
	}

	public function endsWith($subject, $needle)
	{
		return substr($subject, -strlen($needle)) === $needle;
	}

	public function contains($raw, $needle)
	{
		return strpos($raw, $needle) !== false;
	}
}
 