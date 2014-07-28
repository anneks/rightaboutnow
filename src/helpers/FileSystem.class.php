<?php

class FileSystem
{
	/**
	 * @return SplFileInfo[]
	 */
	public function getFilesRecursively($rootDir)
	{
		$it = new RecursiveDirectoryIterator($rootDir);
		$it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::SELF_FIRST);

		$result = array();

		/**
		 * @var $file SplFileInfo
		 */
		foreach ($it as $file)
		{
			if ($file->isDir())
			{
				continue;
			}

			$result[] = $file;
		}

		return $result;
	}
}
