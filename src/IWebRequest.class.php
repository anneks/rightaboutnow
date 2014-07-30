<?php

interface IWebRequest
{
	function get($key, $default=null);
	function post($key, $default=null);
	function routeParam($key, $default=null);
	function path();
}
