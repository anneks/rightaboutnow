<?php

interface IWebResponse
{
	function redirect($url);
	function flash($key, $message);
}
