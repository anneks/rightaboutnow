<?php
define('ROOT', dirname(__DIR__));
define('INC', ROOT.'/src');
require_once(ROOT.'/vendor/autoload.php');
require_once(INC.'/AutoLoader.class.php');
AutoLoader::register(array(
	INC
));