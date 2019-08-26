<?php

class CoreRouter
{
	var $rota;

   public function __construct()
   {
      $this->rota = array();
   }

   public function controller()
   {
      return $this->rota['controller'];
   }

   public function action()
   {
      return $this->rota['action'];
   }

   protected function _autoRoutes()
   {
   	$controller = URL::segment(0);
   	$action = URL::segment(1);

   	if( ! $controller)
   		$controller = 'Default';

   	if( ! $action)
   		$action = 'index';

   	$this->rota = ['controller' => $controller, 'action' => $action];

   	return $this->rota;
   }
}