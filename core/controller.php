<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/*
 * O básico dos controllers
 */
abstract class Controller
{
   protected $request;

   public function __construct()
   {
      $this->request = Request::createFromGlobals();
      $this->response = new Response();
   }

   public static function factory($controller)
   {
      if(empty($controller))
         throw new Exception("Invalid controller name...");

      $controller = ucfirst($controller);
      $classe = 'Controller_' . $controller;

      if(class_exists($classe))
      {
         return new $classe;
      }
      else
      {
         throw new Exception("Controller '$classe' not found...");
      }
   }
}