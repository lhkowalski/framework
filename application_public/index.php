<?php

/*
 * Este é o front-controller da aplicação. Todos os códigos precisam passar por ele.
 */
ini_set('allow_url_fopen', 'ON');
//error_reporting(~E_ALL & ~E_STRICT);
error_reporting(E_ALL);

define('ROOT_DIR', realpath(dirname(__FILE__) . '/../'));
define('CORE_DIR', ROOT_DIR.'/core');
define('APPS_DIR', ROOT_DIR.'/application');
define('LIBS_DIR', ROOT_DIR.'/libraries');

require_once(CORE_DIR.'/init.php');
require_once(ROOT_DIR.'/vendor/autoload.php');

// load settings
Config::load();

if(isset($_SERVER['HTTPS']) and $_SERVER['HTTPS']) 
{
	define('PROTOCOL', 'https');
} 
else
{
	define('PROTOCOL', 'http');
}

define('ROOT_URL', PROTOCOL . '://' . Config::get('ROOT_URL', 'localhost'));

try
{
   $rota = (new Router())->get();
   $controller = $rota['controller'];
   $action = $rota['action'];

   $theController = Controller::factory($controller);

   if( ! method_exists($theController, $action))
      throw new Exception("The action '$action' is invalid", 404);

	echo $theController->$action();
}
catch(Exception $e)
{
	if($e->getCode() == 404)
	{
		header("HTTP/1.0 404 Not Found");
	}

	echo "<h1>".$e->getMessage()."</h1>";
}