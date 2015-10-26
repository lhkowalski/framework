<?php



class Cache

{

	public static function set($chave, $data, $expiration = 3600)

	{

		// monta o nome do arquivo

		$filename = ROOT_DIR."/cache/$chave.txt";

		

		// monta o objeto a ser serializado

		$dados = new stdClass();

		$dados->expiration = (time() + $expiration);

		$dados->data = $data;

		

		// gera o conteudo a ser salvo no arquivo

		$conteudo = serialize($dados);

		

		// guarda o conteudo no arquivo

		try {

			file_put_contents($filename, $conteudo);
			chmod($filename, 0777);
	
		} catch (Expetion $e) {
		}
		
	}

	

	public static function get($chave)

	{

		if( ! $chave)

			return FALSE;

		

		// monta o nome do arquivo

		$filename = "./cache/$chave.txt";

		

		// se o arquivo existe

		if(file_exists($filename))

		{

			// le o arquivo

			$conteudo = file_get_contents($filename);

			// desserializa

			$dados = unserialize($conteudo);

			

			// se o cache é valido

			if($dados->expiration > time())

			{

				return $dados->data;

			}

			else

			{

				return FALSE;

			}

		}

		else

		{

			// senao, retorna falso

			return FALSE;

		}

	}

	public static function remover ($chave) 

	{
		
		$filename = ROOT_DIR."/cache/$chave.txt";

		array_map("unlink", glob($filename));

	}
}