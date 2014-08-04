<?php

interface IRouteMiddleware
{
	function execute(\Slim\Route $route, \Slim\Slim $app);
}