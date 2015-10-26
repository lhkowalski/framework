<?php

class Session
{
   public static $_sessionStarted = FALSE;

   public static function start()
   {
      if(self::$_sessionStarted === FALSE)
      {
         session_start();
         self::$_sessionStarted = TRUE;
      }
   }

   public static function set($key, $data)
   {
      self::start();
      $_SESSION[$key] = $data;
   }

   public static function get($key)
   {
      self::start();

      if(isset($_SESSION[$key]))
         return $_SESSION[$key];
      else
         return FALSE;
   }

   public static function get_all()
   {
      self::start();
      return $_SESSION;
   }

   public static function clear($key = FALSE)
   {
      self::start();
      if($key === FALSE)
      {
         $_SESSION = array();         
      }
      else
      {
         if(isset($_SESSION[$key]))
            unset($_SESSION[$key]);
      }
   }

   public static function destroy()
   {
      if(self::$_sessionStarted === TRUE)
      {
         session_unset();
         session_destroy();
      }
      self::$_sessionStarted = FALSE;
   }

   public static function display()
   {
      self::start();
      echo "<pre>";
      print_r($_SESSION);
      echo "</pre>";
   }
}