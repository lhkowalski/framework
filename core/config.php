<?php

class Config
{
	
	static $config = array(
     'db_user' => 'root',
     'db_pass' => '',
     'db_dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=multisite',     
   );

   static function get($key = '', $padrao = '')
   {
      return isset(self::$config[$key]) ? self::$config[$key] : $padrao;
   }
}