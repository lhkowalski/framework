<?php

class I18N
{
   static $lang = 'br';
   static $permitidas = array('br', 'en', 'es');
   static $strings = array();
   
   public static function get($key)
   {
      return isset(self::$strings[$key]) ? self::$strings[$key] : $key;
   }
   
   public static function set_lang($lang = 'br')
   {
      if(in_array($lang, self::$permitidas))
      {
         self::$lang = $lang;
      }
      else
      {
         self::$lang = 'br';
      }
   }
   
   public static function get_lang()
   {
      if( ! isset(self::$lang))
         self::$lang = 'br';
         
      return self::$lang;
   }
   
   public function load_lang()
   {
      // Carrega o arquivo com o vetor de strings
      $arquivo = ROOT_DIR."/i18n/".self::get_lang().".php";
      
      if(file_exists($arquivo))
      {
         require_once($arquivo);
      }
      else
      {
         throw new Exception('Language file not found.');
      }
   }
}

if( ! function_exists('__') )
{
   function __($key)
   {
      return I18N::get($key);
   }
}