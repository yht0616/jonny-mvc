<?php

define('DS', DIRECTORY_SEPARATOR);
define('APPLICATION_ROOT', dirname(__FILE__) . DS);
define('SERVER_PATH', '/');
define('FULL_SERVER_PATH', 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/');

date_default_timezone_set('America/New_York');

function __autoload($class_name) {
	$file_name = str_replace(array('\\', '/'), DS, APPLICATION_ROOT . $class_name . '.php');
	if (file_exists($file_name) === TRUE) {
		require_once $file_name;
	}
}

if (isset($_SERVER['PATH_INFO'])) {
	$path = $_SERVER['PATH_INFO'];
} else {
	$path = NULL;
}

$uri = $_SERVER['REQUEST_URI'];
$uri = array_slice(explode('/', trim($uri, '/')), 0, 1);
$uri = $uri[0];

$autoload = new \application\core\autoload();
$autoload->do_autoload();

$route = new \application\core\route($path, $uri);
$route->do_route();