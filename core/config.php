<?php

class Config
{
   static function get($key = '', $padrao = '')
   {
      $config = array();
      $config['development'] = array(
        'db_user' => 'root',
        'db_pass' => '',
        'db_dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=appperguntador;charset=utf8',     
      );
      $config['production'] = array(
        'db_user' => 'root',
        'db_pass' => '',
        'db_dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=appperguntador;charset=utf8',     
      );

      $env = defined('APP_ENV') ? defined('APP_ENV') : 'development';

      return isset($config[$env][$key]) ? $config[$env][$key] : $padrao;
   }
}