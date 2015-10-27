<?php
class Router
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

   public function get()
   {
      if (URL::get() == "")
      {
         $this->rota = ['controller' => 'Site', 'action' => 'index'];
      }
      else
      {
         $this->rota = ['controller' => 'Site', 'action' => 'outro'];
      }

      return $this->rota;
   }
}