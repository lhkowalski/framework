<?php

ini_set('allow_url_fopen', 'ON');
//error_reporting(~E_ALL & ~E_STRICT);
error_reporting(E_ALL);

define('ROOT_DIR', realpath(dirname(__FILE__)));
define('CORE_DIR', ROOT_DIR.'/core');
define('APPS_DIR', ROOT_DIR.'/application');

if(isset($_SERVER['HTTPS']) and $_SERVER['HTTPS']) {
	define('PROTOCOL', 'https');
} else {
	define('PROTOCOL', 'http');
}

define('ROOT_URL', PROTOCOL . '://framework');

require_once(CORE_DIR.'/init.php');

try
{
   $rota = (new Router())->get();
   $controller = $rota['controller'];
   $action = $rota['action'];

	echo Controller::factory($controller)->$action();
}
catch(Exception $e)
{
	if($e->getCode() == 404)
	{
		header("HTTP/1.0 404 Not Found");
	}

	echo "<h1>".$e->getMessage()."</h1>";
}