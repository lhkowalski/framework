<?php

class Validador
{	
	public function isNumeroNaoVazio($valor)
	{
		return $this->isNaoVazio($valor) && $this->isNumero($valor);
	}
	
	public function isNumeroNaoZero($valor)
	{
		return $this->isNumero($valor) && $valor != 0;
	}

	public function hasFaixaComprimento($valor, $tamanhoMinimo = 1, $tamanhoMaximo = 1000)
	{
		return $this->hasComprimentoMinimo($valor, $tamanhoMinimo) &&
			$this->hasComprimentoMaximo($valor, $tamanhoMaximo);
	}
	
	public function isStringNaoVazia($valor)
	{
		return $this->isNaoVazio($valor) && 
			$this->isString($valor);
	}
	
	public function isNumero($valor)
	{
		return is_numeric($valor);
	}
	
	public function isString($valor)
	{
		return is_string($valor);
	}

	public function hasComprimentoExato($valor, $tamanho)
	{
		return strlen($valor) === intval($tamanho);
	}
	
	public function hasComprimentoMinimo($valor, $tamanho)
	{
		return strlen($valor) >= intval($tamanho);		
	}
	
	public function hasComprimentoMaximo($valor, $tamanho)
	{
		return strlen($valor) <= intval($tamanho);
	}
	
	public function isNaoVazio($valor)
	{
		return ! empty($valor);
	}
	
	public function hasPadraoRegex($valor, $padrao)
	{
		return preg_match($padrao, $valor);
	}
	
	public function isData($valor)
	{
		$temp = explode('-', $valor);
		return (count($temp) === 3 and checkdate($temp[1], $temp[2], $temp[0]));
	}
	
	public function isEnum($valor, $valoresValidos)
	{
		return (is_array($valoresValidos) and in_array($valor, $valoresValidos));
	}

	public function isEmail($valor)
	{
      return filter_var($valor, FILTER_VALIDATE_EMAIL) !== FALSE;
	}

	public function isIgual($primeiroValor, $segundoValor)
	{
      return $primeiroValor !== $segundoValor;
	}
}