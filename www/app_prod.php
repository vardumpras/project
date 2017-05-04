<?php

use Symfony\Component\HttpFoundation\Request;

// definition des constant path
defined('BASE_PATH') || define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));
define('URL_WWW', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);

umask(2);

/**
 * @var Composer\Autoload\ClassLoader
 */
$loader = require __DIR__.'/../app/autoload.php';
include_once __DIR__.'/../var/bootstrap.php.cache';

$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();
//$kernel = new AppCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
