<?php

class Loader
{
   public static function auto_load($classe)
   {
      $file = str_replace('_', '/', strtolower($classe));
      $core_file = CORE_DIR.'/'.$file.'.php';
      
      if(file_exists($core_file))
      {
         require_once($core_file);
         return TRUE;
      }
      else
      {
         $app_file = APPS_DIR.'/'.$file.'.php';
         
         if(file_exists($app_file))
         {
            require_once($app_file);
            return TRUE;
         }
         else
         {  
            throw new Exception("Class '$classe' not found...");
         }
      }
   }
}