<?php

abstract class BaseSession
{
	public function getId()
	{
		return session_id();
	}

	public function setId($id)
	{
		session_id($id);
	}

	public function createNewSessionId()
	{
		session_regenerate_id(true);
	}

	public function destroy()
	{
		// destroy the data
		$_SESSION = array();

		// destroy the session id cookie - if relevant
		if (ini_get("session.use_cookies"))
		{
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
		}

		// complete the destruction
		session_destroy();
	}

	protected function get($key, $defaultValue = null)
	{
		if (isset($_SESSION[$key]))
		{
			return $_SESSION[$key];
		}

		return $defaultValue;
	}

	protected function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}
}
 