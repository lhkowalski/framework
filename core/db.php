<?php

class DB
{
   static $_pdo;
   static $_pdo_painel;

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

					self::iniciarParametros(self::$_pdo);
				}
				catch(PDOException $e)
				{
					throw new Exception('Cannot create database conection. Message: '.$e->getMessage());
				}
			}
			return self::$_pdo;
		}
		elseif($conexao == 'painel')
		{
			// retorna um objeto PDO
			if(empty(self::$_pdo_painel))
			{
				try
				{
					self::$_pdo_painel = new PDO(Config::get('db_dsn_painel'), 
										Config::get('db_user_painel'),
										Config::get('db_pass_painel'));

					self::iniciarParametros(self::$_pdo_painel);
				}
				catch(PDOException $e)
				{
					throw new Exception('Cannot create database conection. Message: '.$e->getMessage());
				}
			}
			return self::$_pdo_painel;
		}
   }

   private static function iniciarParametros($conn) {
		$init = array();
		//$init[] = "SET NAMES 'utf8'";
		//$init[] = "SET character_set_connection=utf8";
		//$init[] = "SET character_set_client=utf8";
		//$init[] = "SET character_set_results=utf8";
		$init[] = "SET SESSION time_zone = 'America/Sao_Paulo'";

		foreach ($init as $query) {
			$sql = $conn->prepare($query);
			$sql->execute();
		}


		$sql = null;
		unset($sql);
   }
}