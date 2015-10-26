<?php

/*
 * O básico dos models
 */
abstract class Model
{   
   public static function factory($model)
   {
      if(empty($model))
         throw new Exception("Invalid model name...");

      $model = ucfirst($model);
      $classe = $model.'_Model';

      if(class_exists($classe))
      {
         return new $classe;
      }
      else
      {
         throw new Exception("Model '$classe' not found...");
      }
   }
}