<?php



class GET

{

   public static function int($chave)

   {

      // return filter_input(INPUT_GET, $chave, FILTER_SANITIZE_NUMBER_INT);

      return isset($_GET[$chave]) ? intval($_GET[$chave]) : FALSE;

   }

   

   public static function clean_str($chave)

   {

      return filter_input(INPUT_GET, $chave, FILTER_SANITIZE_STRING);

   }

   

   public static function str($chave)

   {

      return isset($_GET[$chave]) ? htmlspecialchars(trim($_GET[$chave])) : FALSE;

   }

}