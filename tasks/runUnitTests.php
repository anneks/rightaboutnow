<?php
$testDir = dirname(__DIR__).'/tests/';
require_once($testDir.'/unitBootstrap.php');

$phpunit = dirname(__DIR__).'/vendor/phpunit/phpunit/phpunit';

passthru("$phpunit --bootstrap $testDir/unitBootstrap.php $testDir/unit/");
