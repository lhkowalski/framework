<?php

/*
 * O básico dos controllers
 */
abstract class Controller
{
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