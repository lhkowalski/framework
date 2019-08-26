<?php

$loader = CORE_DIR.'/loader.php';

if(file_exists($loader))
{
   require_once($loader);
}
else
{
   throw new Exception('Loader not found...');
}

// Carregador de classes
spl_autoload_register(array('Loader', 'auto_load'));