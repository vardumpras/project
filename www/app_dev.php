<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

umask(2);
error_reporting(E_ALL);
ini_set("display_errors", 1);

// definition des constant path
defined('BASE_PATH') || define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));
define('URL_WWW', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../app/autoload.php';
Debug::enable();

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
