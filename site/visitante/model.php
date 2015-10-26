<?php

class Visitante_Model extends Model
{
	protected $_ip = false;
	protected $_debug = false;
	
	public function set_ip_teste($ip)
	{
		$this->_ip = $ip;
	}
	
	public function ativar_debug()
	{
		$this->_debug = true;
	}
	
	public function get_estado_visitante()
	{
		// verifica na sessão
		//$estado = Session::get('uf_visitante');
		
		if($this->_debug)
			echo "UF da sessão: $estado<br>";
		
		if( ! $estado)
		{
			if($this->_debug)
				echo "UF não estava na sessão<br>";
			
			//UTIL::log_it("Maxmind - antes ", date('d/m/Y H:i:s'));	
			$estado = $this->_get_estado_por_ip();
			//UTIL::log_it("Maxmind - depois ", date('d/m/Y H:i:s'));	

			if($this->_debug)
				echo "UF retornada pela consulta: $estado<br>";
			
			// poe na sessao
			Session::set('uf_visitante', $estado);
		}
		
		return $estado;
	}
	
	protected function _get_estado_por_ip()
	{
		// verificar se há cache de cookie
		$estado = $this->_get_cookie();
		
		if($this->_debug)
				echo "UF salva em cookie: $estado<br>";
		
		if( ! $estado)
		{
			// se não estiver
			// procura na api
			// telize
			if($this->_debug)
				echo "UF não estava em cookie<br>";
			
			//$estado = $this->_consultar_api_telize();
			
			if($this->_debug)
				echo "UF retornada pela Telize: $estado<br>";
			
			// maxmind
			if($estado === FALSE)
				$estado = $this->_consultar_api_maxmind();
		
			if($this->_debug)
				echo "UF retornada pela Mxmind: $estado<br>";
				
			// salvar no cookie
			$this->_set_cookie($this->_ip_cliente(), $estado);
		}
		
		return $estado;
	}
	
	public function ip_cliente()
	{
		return $this->_ip_cliente();
	}

	protected function _ip_cliente()
	{
		//return "187.16.69.135";
		if($this->_ip !== false)
		{
			if($this->_debug)
				echo "Usando IP de teste: {$this->_ip}<br>";
			return $this->_ip;
		}
		else
		{
			
			$ip = '';

			$HTTP_X_FORWARDED_FOR = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '';
			$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];

			//testes
			//$HTTP_X_FORWARDED_FOR = '172.16.66.253, 177.159.153.186';
			//$REMOTE_ADDR = '172.31.9.116';

			if(strlen($HTTP_X_FORWARDED_FOR) > 0) {
				$ips = explode(',', $HTTP_X_FORWARDED_FOR);
				if(count($ips) > 0) {
					$ip = $ips[count($ips) - 1];
				} else {
					$ip = $REMOTE_ADDR;
				}
			} else {
				$ip = $REMOTE_ADDR;
			}

			if($this->_debug) {
				echo "Usando IP do visitante: $ip<br>",
					 "HTTP_X_FORWARDED_FOR:$HTTP_X_FORWARDED_FOR<br>",
					 "REMOTE_ADDR:$REMOTE_ADDR<br>";
			}

			$this->_ip = trim($ip);
			return $this->_ip;
		}
	}
	
	protected function _get_cookie()
	{
		if(isset($_COOKIE['geoip']))
		{
			$dadosCookie = $_COOKIE['geoip'];
			$dados = json_decode(base64_decode($dadosCookie));
			
			if(isset($dados->ip, $dados->estado))
			{
				if($this->_ip_cliente() != $dados->ip)
				{
					return FALSE;
				}
				else
				{
					return $dados->estado;
				}
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	
	protected function _set_cookie($ip, $estado)
	{
		$dados = new stdClass;
		$dados->ip = $ip;
		$dados->estado = $estado;
		
		$dadosCookie = base64_encode(json_encode($dados));
		setcookie('geoip', $dadosCookie, time() + (30 * 24 * 60 * 60));
	}
	
	protected function _consultar_api_telize()
	{
		$url = "http://www.telize.com/geoip/";
		$url .= $this->_ip_cliente();
		
		if($this->_debug)
			echo "Consultando Telize na URL: $url<br>";

		$dados_json = file_get_contents($url);
		$dados = json_decode($dados_json);
		
		if($this->_debug)
			echo "Resposta da Telize: <br><pre>$dados_json</pre><br>";
		
		if(isset($dados->region))
			return $this->_mapear_estado_para_sigla($dados->region);
		else
			return FALSE;
	}
	
	public function _consultar_api_maxmind()
	{
		$username = '103457';
		$password = 'IKGMgkoTZfI0';
		$url      = "https://$username:$password@geoip.maxmind.com/geoip/v2.1/city/" . $this->_ip_cliente();
		
		if($this->_debug)
			echo "Consultando Maxmind na URL: $url<br>";
		
		$data_json = file_get_contents($url);
		$data     = json_decode($data_json);
		
		if($this->_debug)
			echo "Resposta da Maxmind: <br><pre>$data_json</pre><br>";
		
		if(isset($data->subdivisions))
		{
			if(count($data->subdivisions) > 0)
			{
				$estado = $data->subdivisions[0];
				
				if(isset($estado->iso_code))
				{
					return $estado->iso_code;
				}
			}
		}
		
		if($this->_debug)
			echo "Maxmind não achou nada. Retornando valor padrão.<br>";
		
		return "DF";
	}
	
	protected function _mapear_estado_para_sigla($estado)
	{
		return Util::estado_sigla_por_nome($estado);
	}
}