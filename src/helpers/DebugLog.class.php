<?php

class DebugLog
{
	public static function log($msg, $file = '/tmp/debuglog')
	{
		file_put_contents($file, $msg . "\n", FILE_APPEND);
	}
}
