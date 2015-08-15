<?php

class DebugLog
{
	private static function write($msg, $file)
	{
		file_put_contents($file, $msg . "\n", FILE_APPEND);
	}

	public static function log($msg, $file = '/tmp/debuglog')
	{
		if (is_array($msg))
		{
			self::write(print_r($msg, true), $file);
		}

		elseif (is_null($msg))
		{
			self::write('null', $file);
		}

		elseif (is_bool($msg))
		{
			self::write($msg ? 'true' : 'false', $file);
		}

		elseif (is_object($msg))
		{
			self::write(get_class($msg), $file);
		}

		else
		{
			self::write($msg, $file);
		}
	}

	public static function separator($file = '/tmp/debuglog')
	{
		self::write("\n\n\n\n===================================\n\n\n\n", $file);
	}
}
