<?php

class AutoLoader
{
	private static $dirs;

	public static function register(array $dirs)
	{
		self::$dirs = array_merge(array(__DIR__), $dirs);
		spl_autoload_register(array('AutoLoader', 'load'));
	}

	public static function load($class)
	{
		$filename = "$class.class.php";

		foreach (self::$dirs as $dir)
		{
			$it = new RecursiveDirectoryIterator($dir);
			$it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::SELF_FIRST);

			/**
			 * @var $file SplFileInfo
			 */
			foreach ($it as $file)
			{
				if ($file->isDir())
				{
					continue;
				}

				if ($file->getFilename() == $filename)
				{
					/** @noinspection PhpIncludeInspection */
					return require_once($file->getRealPath());
				}
			}
		}

		return false;
	}
}
