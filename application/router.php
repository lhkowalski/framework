<?php

class Router extends CoreRouter
{
   public function get()
   {
      if (URL::get() == "")
      {
         $this->rota = ['controller' => 'Site', 'action' => 'index'];
      }
      else
      {
         $this->_autoRoutes();
      }

      return $this->rota;
   }
}