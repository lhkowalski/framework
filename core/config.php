<?php
$testServer = false;
if( strstr( $_SERVER['SERVER_NAME'], 'bilheteriadigital.dyndns.biz' ) )
	$testServer = true;

$posSeparadorParamsGET = strpos($_SERVER['REQUEST_URI'],'?');
if( !is_numeric($posSeparadorParamsGET) )
	$posSeparadorParamsGET = strlen($_SERVER['REQUEST_URI']);

$beforeParamsGET = substr( $_SERVER['REQUEST_URI'], 0, $posSeparadorParamsGET );
$mobileTemplate = false;
if( strstr( $beforeParamsGET, '/m/' ) || substr( $beforeParamsGET, -2 ) == '/m' )
	$mobileTemplate = true;

class Config
{
	
static $config = array(

     /*
     'db_user' => 'painelbd_site',
     'db_pass' => 'aG0W7AH1dqvCbs5',
     'db_dsn' => 'mysql:host=bilheteriadata.cqqmsg088bud.sa-east-1.rds.amazonaws.com;port=3315;dbname=painelbd',
     //'db_dsn' => 'mysql:host=189.113.164.249;port=3310;dbname=site_bilheteria',
     //'db_dsn' => 'mysql:host=192.168.17.2;port=3310;dbname=site_bilheteria',
	  
     'db_user_painel' => 'painelbd_site',
     'db_pass_painel' => 'aG0W7AH1dqvCbs5',
     'db_dsn_painel' => 'mysql:host=bilheteriadata.cqqmsg088bud.sa-east-1.rds.amazonaws.com;port=3315;dbname=painelbd',
     //'db_dsn_painel' => 'mysql:host=189.113.164.249;port=3310;dbname=painelbd',
     //'db_dsn_painel' => 'mysql:host=192.168.17.2;port=3310;dbname=painelbd',
     */
/*
     'db_user' => 'bilheteria_user',
     'db_pass' => 'ch1HI=fawTJJ',
     'db_dsn' => 'mysql:host=189.113.164.249;port=3310;dbname=site_bilheteria',*/
  
     'db_user' => 'painelbd_site',
     'db_pass' => 'aG0W7AH1dqvCbs5',
     'db_dsn' => 'mysql:host=bilheteriadata.cqqmsg088bud.sa-east-1.rds.amazonaws.com;port=3315;dbname=painelbd',

     'db_user_painel' => 'painelbd_site',
     'db_pass_painel' => 'aG0W7AH1dqvCbs5',
     'db_dsn_painel' => 'mysql:host=bilheteriadata.cqqmsg088bud.sa-east-1.rds.amazonaws.com;port=3315;dbname=painelbd',

     //'pdv' => "BD2013",
	  'templatePath' => 'site',
	  'url_consulta' => array(

	  		'DRI0487487893' => 'http://189.113.164.245/posmanager/api/DRI0487487893/',

			'WOOWZONE0001' => 'http://189.113.164.245/posmanager/api/WOOWZONE0001/',

			//'VIAT000001' => 'http://189.113.164.245/posmanager/api/VIAT000001/',

			'VENDAONLINEBD' => 'https://painel.bilheteriadigital.com/api/VENDAONLINEBD/',
			
			'SITEHOLIONE' => 'http://painel.bilheteriadigital.com/api/SITEHOLIONE/',

	  ),

	  'pdvs' => array("DRI0487487893",
					  "WOOWZONE0001",
					  //"VIAT000001",
					  //"BD2013"
					  'VENDAONLINEBD',
					  'SITEHOLIONE'
					  ),

	  

	  'cep_origem_sedex' => "74210050",

	  //AQUI COLOCAR O PATH DO TEMPLATE A SER CARREGADO DE ACORDO COM A VERSÃO QUE SE ESTÁ ACESSANDO, COMO DESCOBRIR DE QUAL VERSÃO ESTÁ ACESSANDO? NOME DO SITE, SUBDIRETÓRIO ANTES OU DEPOIS DO DOMÍNIO...

   );

   static function get($key = '', $padrao = '')



   {



      return isset(self::$config[$key]) ? self::$config[$key] : $padrao;



   }

}

if($testServer)
{
	Config::$config['db_user'] = 'bilheteria_user';
	Config::$config['db_pass'] = 'dev';
	Config::$config['db_dsn'] = 'mysql:host=maquinamysql;port=3306;dbname=site_bilheteria';
}

if($mobileTemplate)
	Config::$config['templatePath'] = '../m';