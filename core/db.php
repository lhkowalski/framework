<?php

class DB
{
   static $_pdo;

   public static function get($conexao = 'site')
   {
		if($conexao == 'site')
		{
			// retorna um objeto PDO
			if(empty(self::$_pdo))
			{
				try
				{
					self::$_pdo = new PDO(Config::get('db_dsn'), 
										Config::get('db_user'),
										Config::get('db_pass'));

					self::$_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
					self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				}
				catch(PDOException $e)
				{
					throw new Exception('Cannot create database conection. Message: '.$e->getMessage());
				}
			}
			return self::$_pdo;
		}
   }
}