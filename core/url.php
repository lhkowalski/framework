<?php
class URL
{
   protected static $_uri;
   protected static $_segments;
   public static function base()
   {
      return ROOT_URL;
   }
   public static function redirect($url, $is301 = FALSE)
   {
      if(Session::$_sessionStarted)
      {
         echo "<script>location.href='$url';</script>";
         die();
      }
      else
      {
         if($is301)
            header('HTTP/1.1 301 Moved Permanently');
         header("Location: $url");
      }
      exit;
   }
   public static function segment($index = 0, $default = FALSE)
   {
      self::_parse_url();
      if(isset(self::$_segments[$index]))
         return self::$_segments[$index];
      else
         return $default;
   }
   public static function get()
   {
      if( ! isset(self::$_uri))
         self::$_uri = isset($_GET['_r_']) ? $_GET['_r_'] : '';
      return self::$_uri;
   }
   protected static function _parse_url()
   {
      if(!is_array(self::$_segments))
      {
         if(!isset(self::$_uri))
            self::$_uri = $_GET['_r_'];
         $partes          = explode('/', self::$_uri);
         self::$_segments = array();
         foreach($partes as $p)
         {
            if(!empty($p))
               self::$_segments[] = $p;
         }
      }
   }
}