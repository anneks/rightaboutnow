<?php

interface IWebRequest
{
	function get($key, $default=null);

	/**
	 * All get parameters
	 * @return array
	 */
	function getAll();
	function post($key, $default=null);

	/**
	 * All post parameters
	 * @return array
	 */
	function postAll();
	function routeParam($key, $default=null);
	function path();
}
