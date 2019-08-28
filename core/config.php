<?php

class Config
{
   static public $config = [];

   /**
    * Get every environment var, put on cache and do some transformations
    */
   static function load()
   {
      self::$config = getenv();

      if(isset(self::$config['DATABASE_URL']))
      {
         // parse the details of this var
         $urlParts = parse_url(self::$config['DATABASE_URL']);

         self::$config['DB_DRIVER'] = isset($urlParts['scheme']) ? $urlParts['scheme'] : '';
         self::$config['DB_HOST']   = isset($urlParts['host']) ? $urlParts['host'] : '';
         self::$config['DB_PORT']   = isset($urlParts['port']) ? $urlParts['port'] : '';
         self::$config['DB_USER']   = isset($urlParts['user']) ? $urlParts['user'] : '';
         self::$config['DB_PASS']   = isset($urlParts['pass']) ? $urlParts['pass'] : '';
         self::$config['DB_NAME']   = isset($urlParts['path']) ? ltrim($urlParts['path'], '/') : '';
         self::$config['DB_DSN']    = self::getDSN();
      }
   }

   static function getDSN()
   {
      // TODO: use a third part to generate the DSN
      switch (self::$config['DB_DRIVER']) 
      {
         case 'mysql':
            return sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8', self::$config['DB_HOST'], self::$config['DB_PORT'], self::$config['DB_NAME']);
            break;

         case 'pgsql':
         case 'postgres':
            return sprintf('pgsql:host=%s;port=%d;dbname=%s;options=\'--client_encoding=UTF8\'', self::$config['DB_HOST'], self::$config['DB_PORT'], self::$config['DB_NAME']);
            break;            

         case 'sqlite':
         case 'sqlite2':

            $db_name = self::$config['DB_NAME'];

            if($db_name !== ':memory:')
               $db_name = '/' . $db_name;

            return sprintf('%s:%s', self::$config['DB_DRIVER'], $db_name);
            break;

         default:
            return '';
            break;
      }
   }

   static function get($key = '', $padrao = '')
   {
      return isset(self::$config[$key]) ? self::$config[$key] : $padrao;
   }
}