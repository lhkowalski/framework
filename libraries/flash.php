<?php

/**
 * Classe usada para armazenar e mostrar flash messages
 */
class Flash
{
	protected static $_session_key = 'flash_messages';
	
	/*
	 * cria uma mensagem
	 * tipo = um tipo de mensagem entre danger, warning, info, success
	 * mensagem = mensagem a ser mostrada
	 * chamada = chamada da mensagem. aparece em negrito antes da mensagem
	 */
	public static function set($tipo = 'info', $mensagem = '', $chamada = FALSE)
	{
		$array_mensagem = array(
			'tipo' => $tipo,
			'mensagem' => $mensagem,
			'chamada' => $chamada
		);
		
		$mensagens = self::get();
		$mensagens[] = $array_mensagem;
		
		Session::set(self::$_session_key, $mensagens);
	}
	
	/*
	 * retorna um vetor com as mensagens que estão na sessão.
	 * pode retornar um vetor vazio.
	 */
	public static function get()
	{
		$mensagens = Session::get(self::$_session_key);
		
		if( ! is_array($mensagens))
		   $mensagens = array();
			
		return $mensagens;
	}
	
	/*
	 * Limpa todas as mensagens, removendo a chave da sessão.
	 */
	public static function clear()
	{
		Session::clear(self::$_session_key);
	}
	
	/*
	 * Usa a classe Alert para mostrar as mensagens que estão na sessão.
	 * De fato, mostra as mensagens.
	 */
	public static function show()
	{
		$mensagens = self::get();
		
		if(count($mensagens) > 0)
		{
			foreach($mensagens as $mensagem)
			{
				switch($mensagem['tipo'])
				{
					case 'success':
						echo Alert::success($mensagem['mensagem'], $mensagem['chamada']);
						break;
					case 'warning':
						echo Alert::warning($mensagem['mensagem'], $mensagem['chamada']);
						break;
					case 'danger':
						echo Alert::danger($mensagem['mensagem'], $mensagem['chamada']);
						break;
					default:
						echo Alert::info($mensagem['mensagem'], $mensagem['chamada']);
						break;
				}
			}
			
			self::clear();
		}
	}
}