<?php

class Validador
{
	protected $mensagemPadrao = 'Problema de validaçao. Por favor, digite todos os dados corretamente.';
	
	public function isNumeroNaoVazio($valor, $mensagem = false)
	{
		$this->isNaoVazio($valor, $mensagem);
		$this->isNumero($valor, $mensagem);
	}
	
	public function isNumeroNaoZero($valor, $mensagem = false)
	{
		$this->isNumero($valor, $mensagem);
		if($valor == 0)
		{
			throw new Exception($mensagem ? $mensagem : $this->mensagemPadrao);
		}
	}

	public function hasFaixaComprimento($valor, $tamanhoMinimo = 1, $tamanhoMaximo = 1000, $mensagem = false)
	{
		$this->hasComprimentoMinimo($valor, $tamanhoMinimo, $mensagem);
		$this->hasComprimentoMaximo($valor, $tamanhoMaximo, $mensagem);
	}
	
	public function isStringNaoVazia($valor, $mensagem = false)
	{
		$this->isNaoVazio($valor, $mensagem);
		$this->isString($valor, $mensagem);
	}
	
	public function isNumero($valor, $mensagem = false)
	{
		if( ! is_numeric($valor))
		{
			throw new Exception($mensagem ? $mensagem : $this->mensagemPadrao);
		}
	}
	
	public function isString($valor, $mensagem = false)
	{
		if( ! is_string($valor))
		{
			throw new Exception($mensagem ? $mensagem : $this->mensagemPadrao);
		}
	}

	public function hasComprimentoExato($valor, $tamanho, $mensagem = false)
	{
		if(strlen($valor) != intval($tamanho))
		{
			throw new Exception($mensagem ? $mensagem : $this->mensagemPadrao);
		}		
	}
	
	public function hasComprimentoMinimo($valor, $tamanho, $mensagem = false)
	{
		if(strlen($valor) < intval($tamanho))
		{
			throw new Exception($mensagem ? $mensagem : $this->mensagemPadrao);
		}		
	}
	
	public function hasComprimentoMaximo($valor, $tamanho, $mensagem = false)
	{
		if(strlen($valor) > intval($tamanho))
		{
			throw new Exception($mensagem ? $mensagem : $this->mensagemPadrao);
		}		
	}
	
	public function isNaoVazio($valor, $mensagem = false)
	{
		if(empty($valor))
		{
			throw new Exception($mensagem ? $mensagem : $this->mensagemPadrao);
		}
	}
	
	public function hasPadraoRegex($valor, $padrao, $mensagem = false)
	{
		if( ! preg_match($padrao, $valor))
		{
			throw new Exception($mensagem ? $mensagem : $this->mensagemPadrao);
		}		
	}
	
	public function isData($valor, $mensagem = false)
	{
		$temp = explode('-', $valor);
		if(count($temp) != 3 or ! checkdate($temp[1], $temp[2], $temp[0]))
		{
			throw new Exception($mensagem ? $mensagem : $this->mensagemPadrao);
		}
	}
	
	public function isEnum($valor, $valoresValidos, $mensagem = false)
	{
		if( ! is_array($valoresValidos) or ! in_array($valor, $valoresValidos))
		{
			throw new Exception($mensagem ? $mensagem : $this->mensagemPadrao);
		}
	}

	public function isEmail($valor, $mensagem = false);
	{
      if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE)
		{
			throw new Exception($mensagem ? $mensagem : $this->mensagemPadrao);
		}
	}

	public function isIgual($primeiroValor, $segundoValor, $mensagem = false);
	{
      if($primeiroValor !== $segundoValor)
		{
			throw new Exception($mensagem ? $mensagem : $this->mensagemPadrao);
		}
	}
}