<?php

class POST
{
   public static function int($chave)
   {
      return filter_input(INPUT_POST, $chave, FILTER_SANITIZE_NUMBER_INT);
   }

   public static function clean_str($chave)
   {
      return filter_input(INPUT_POST, $chave, FILTER_SANITIZE_STRING);
   }

   public static function str($chave)
   {
      return isset($_POST[$chave]) ? htmlspecialchars(trim($_POST[$chave])) : FALSE;
   }

   public static function raw($chave)
   {
      return isset($_POST[$chave]) ? $_POST[$chave] : FALSE;
   }

   public static function all() 
   {
      $resp = array();  
      foreach ($_POST as $key => $value) 
      {
         $resp[$key] = htmlspecialchars(trim($value));
      }

      return $resp;
   }
}