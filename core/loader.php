<?php

class Loader
{
   public static function auto_load($classe)
   {
      $file = str_replace('_', '/', strtolower($classe));

      $app_file = APPS_DIR.'/'.$file.'.php';
      
      if(file_exists($app_file))
      {
         require_once($app_file);
         return TRUE;
      }
      else
      {
         $lib_file = LIBS_DIR.'/'.$file.'.php';

         if(file_exists($lib_file))
         {
            require_once($lib_file);
            return TRUE;
         }
         else
         {  
            $core_file = CORE_DIR.'/'.$file.'.php';

            if(file_exists($core_file))
            {
               require_once($core_file);
               return TRUE;
            }
            else
            {  
               throw new Exception("Class '$classe' not found...");
            }
         }
      }
   }
}