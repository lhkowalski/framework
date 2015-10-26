<?php
class Util
{
   public static function ps_status($codigo = '1')
   {
      switch($codigo)
      {
         case '1':
            return 'Aguardando pagamento';
            break;
         case '2':
            return 'Em análise';
            break;
         case '3':
            return 'Pago';
            break;
         case '4':
            return 'Pago'; // Pagamento liberado ao vendedor 
            break;
         case '5':
            return 'Pagamento contestado'; // Em disputa
            break;
         case '6':
            return 'Devolvido';
            break;
         case '7':
            return 'Cancelado';
            break;
         case '253':
            return 'Transferência';
            break;
         case '254':
            return 'Cancelado';
            break;
         case '255':
            return 'Aprovado';
            break;
         default:
            return 'Não Concluido';
      }
   }
   public static function isValidEmail($email)
   { 
      if(filter_var($email, FILTER_VALIDATE_EMAIL))
      {
         $dominio = explode('@', $email);
         $dominio = $dominio[1];
         //$dominio = idn_to_ascii($dominio[1]);

         return checkdnsrr($dominio, 'A');
      }
      else
      {
         return false;
      }
   }

   public static function mask($mascara, $string)
   {
      $string = str_replace(" ", "", $string);
      for($i = 0; $i < strlen($string); $i++)
      {
         $mascara[strpos($mascara,"#")] = $string[$i];
      }
      return $mascara;
   }
   public static function check_cnpj($cnpj)
   {
   		if (strlen($cnpj) <> 18) return FALSE;
   		$soma1 = ($cnpj[0] * 5) +
   		($cnpj[1] * 4) +
   		($cnpj[3] * 3) +
   		($cnpj[4] * 2) +
   		($cnpj[5] * 9) +
   		($cnpj[7] * 8) +
   		($cnpj[8] * 7) +
   		($cnpj[9] * 6) +
   		($cnpj[11] * 5) +
   		($cnpj[12] * 4) +
   		($cnpj[13] * 3) +
   		($cnpj[14] * 2);
   		$resto = $soma1 % 11;
   		$digito1 = $resto < 2 ? 0 : 11 - $resto;
   		$soma2 = ($cnpj[0] * 6) +
   		($cnpj[1] * 5) +
   		($cnpj[3] * 4) +
   		($cnpj[4] * 3) +
   		($cnpj[5] * 2) +
   		($cnpj[7] * 9) +
   		($cnpj[8] * 8) +
   		($cnpj[9] * 7) +
   		($cnpj[11] * 6) +
   		($cnpj[12] * 5) +
   		($cnpj[13] * 4) +
   		($cnpj[14] * 3) +
   		($cnpj[16] * 2);
   		$resto = $soma2 % 11;
   		$digito2 = $resto < 2 ? 0 : 11 - $resto;
   		return (($cnpj[16] == $digito1) && ($cnpj[17] == $digito2));
   }
   public static function remover_str($remover, $str)
   {
      for( $i=0; $i < strlen($remover); $i++ ) { 
         if( strpos($str, $remover[$i]) !== false ) {
            $str = str_replace($remover[$i], '', $str);
         }
      }
      return $str;
   }
   public static function cpf_limpar($cpf) 
   {
      return UTIL::remover_str('.- ', $cpf);
   }
   public static function check_cpf($cpf)
   {
      $eh_valido = FALSE;
      $cpf = str_replace(".", "", str_replace("-", "", $cpf) );
      $s = $cpf;
      $c = substr($s, 0, 9);
      $dv = substr($s, 9, 2);
      $d1 = 0;
      $v = false;
       for ($i = 0; $i < 9; $i++){
           $d1 = $d1 + substr($c, $i, 1) * (10 - $i);
       }
       if($d1 == 0){
           return FALSE;
           $v = true;
       }
       $d1 = 11 - ($d1 % 11);
       if($d1 > 9){
           $d1 = 0;
       }
       if(substr($dv, 0, 1) != $d1){
           return FALSE;
           $v = true;
       }
       $d1 = $d1 * 2;
       for ($i = 0; $i < 9; $i++){
           $d1 = $d1 + substr($c, $i, 1) * (11 - $i);
       }
       $d1 = 11 - ($d1 % 11);
       if($d1 > 9){
           $d1 = 0;
       }
       if(substr($dv, 1, 1) != $d1){
           return FALSE;
           $v = true;
       }
       if(!$v){
           return TRUE;
       }
   }
   static public function slugify($text)
   { 
      // replace non letter or digits by -
      $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
      // trim
      $text = trim($text, '-');
      // transliterate
      setlocale(LC_ALL, 'pt_BR');
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
      // lowercase
      $text = strtolower($text);
      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);
      if (empty($text))
      {
         return 'n-a';
      }
      return $text;
   }
   public static function day_of_week($date)
   {
      // Transformar em time
      // obter via getdate
      $data = getdate(strtotime($date));
      // mapear os nomes dos dias
      $dias = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
      return $dias[$data['wday']];
   }
   public static function data_to_mysql($data)
   {
      $data = explode("/", $data);
      $data = array_reverse($data);
      $data = implode("-", $data);
      return $data;
   }
   public static function transliterate($str)
   {
      setlocale(LC_ALL, 'pt_BR');
      $str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);
      return preg_replace('~[^-\w]+~', '', $str);
   }
   public static function mysql_to_data($data)
   {
      $data = explode("-", $data);
      $data = array_reverse($data);
      $data = implode("/", $data);
      return $data;
   }
   public static function data_parts($data, $tipo_retorno, $incluir_ano = TRUE)
   {
      $pecas = explode("-", $data);
      $retorno = array();
      $retorno['dia'] = $pecas[2];
      if($tipo_retorno = 'amigavel')
      {
         $retorno['mes'] = self::decode_mes($pecas[1]);
      }
      else
      {
         $retorno['mes'] = $pecas[1];
      }
      if($incluir_ano)
         $retorno['ano'] = $pecas[0];
      return $retorno;
   }
   public static function decode_mes($mes)
   {
      $meses = array(
         '01' => 'janeiro',
         '02' => 'fevereiro',
         '03' => 'março',
         '04' => 'abril',
         '05' => 'maio',
         '06' => 'junho',
         '07' => 'julho',
         '08' => 'agosto',
         '09' => 'setembro',
         '10' => 'outubro',
         '11' => 'novembro',
         '12' => 'dezembro'
      );
      return isset($meses[$mes]) ? $meses[$mes] : $mes;
   }
	
	public static function decode_mes_curto($mes)
   {
		$mes = str_pad($mes, 2, '0', STR_PAD_LEFT);
		$mesStr = self::decode_mes($mes);
		
		return substr($mesStr, 0, 3);
   }
	
   public static function encode_valor($valor)
   {
      $valor = str_replace('.', '', $valor);
      return str_replace(',', '.', $valor);
   }
   public static function decode_valor($valor)
   {
      return str_replace('.', ',', $valor);
   }
   public static function log_it($mensagem, $prefixo = '')
   {
   	$arquivo = ROOT_URL . "/logs/".date("d_m_Y").".txt";
   	file_put_contents($arquivo, (($prefixo) ? $prefixo . '  ' : '') . $mensagem, FILE_APPEND);
   }
   public static function tamanho_mes($mes, $ano)
   {
   	$tamanhos = array(
   			'01' => '31',
   			'02' => '28',
   			'03' => '31',
   			'04' => '30',
   			'05' => '31',
   			'06' => '30',
   			'07' => '31',
   			'08' => '31',
   			'09' => '30',
   			'10' => '31',
   			'11' => '30',
   			'12' => '31'
   	);
   	$retorno = $tamanhos[$mes];
   	if($ano % 4 == 0 and $mes == '02')
   		$retorno = '29';
   	return $retorno;
   }
   public static function inicio_mes($mes, $ano)
   {
   	$data = "$ano-$mes-01";
   	$info = getdate(strtotime($data));
   	return $info['wday'];
   }
   public static function get_calendario($mes, $ano)
   {
   	$dias = array();
   	$tamanho_mes = self::tamanho_mes($mes, $ano);
   	$dia_inicio_mes = self::inicio_mes($mes, $ano);
   	// Passar em falso os dias que não do mes atual
   	for($i = 0; $i < $dia_inicio_mes; $i++)
   		$dias[] = FALSE;
   		// Percorrer o tamanho do mes atual
   		for($i = 0; $i < $tamanho_mes; $i++)
   		$dias[] = ($i + 1);
   		// Se o vetor não tem tamanho multiplo de 7, preencher até ser
   		while(count($dias) % 7 != 0)
   			$dias[] = FALSE;
   			$linhas = array();
   			$linha = 1;
   			foreach($dias as $key => $d)
   			{
   			if( ! isset($linhas[$linha]))
   			{
   			$linhas[$linha] = new stdClass();
   			$linhas[$linha]->colunas = array();
   			}
   			$linhas[$linha]->colunas[] = $d;
   			if($key % 7 == 6)
   				$linha++;
   			}
   			/*
   			echo "<pre>";
   			print_r($linhas);
   			die("</pre>");
   			*/
   			return $linhas;
   }
   public static function data_por_extenso()
   {
   	$meses = array (1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
   	$diasdasemana = array (1 => "Segunda-Feira",2 => "Terça-Feira",3 => "Quarta-Feira",4 => "Quinta-Feira",5 => "Sexta-Feira",6 => "Sábado",0 => "Domingo");
   	$hoje = getdate();
   	$dia = $hoje["mday"];
   	$mes = $hoje["mon"];
   	$nomemes = $meses[$mes];
   	$ano = $hoje["year"];
   	$diadasemana = $hoje["wday"];
   	$nomediadasemana = $diasdasemana[$diadasemana];
   	return "$nomediadasemana, $dia de $nomemes de $ano";
   }
   public static function time_por_extenso($time = FALSE, $full = FALSE)
   {
   	if( ! $time)
   	   $time = time();
   	$meses = array (1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
   	$diasdasemana = array (1 => "Segunda-Feira",2 => "Terça-Feira",3 => "Quarta-Feira",4 => "Quinta-Feira",5 => "Sexta-Feira",6 => "Sábado",0 => "Domingo");
   	$hoje = getdate($time);
   	$dia = $hoje["mday"];
   	$mes = $hoje["mon"];
   	$nomemes = $meses[$mes];
   	$ano = $hoje["year"];
   	$diadasemana = $hoje["wday"];
   	$nomediadasemana = $diasdasemana[$diadasemana];
   	if( ! $full)
   	return "$dia de $nomemes de $ano";
   	else
   		return "$nomediadasemana, $dia de $nomemes de $ano";
   }
	
	public static function estados()
	{
		$estados = array("AC"=>"Acre", "AL"=>"Alagoas", "AM"=>"Amazonas", "AP"=>"Amapá","BA"=>"Bahia","CE"=>"Ceará","DF"=>"Distrito Federal","ES"=>"Espírito Santo","GO"=>"Goiás","MA"=>"Maranhão","MT"=>"Mato Grosso","MS"=>"Mato Grosso do Sul","MG"=>"Minas Gerais","PA"=>"Pará","PB"=>"Paraíba","PR"=>"Paraná","PE"=>"Pernambuco","PI"=>"Piauí","RJ"=>"Rio de Janeiro","RN"=>"Rio Grande do Norte","RO"=>"Rondônia","RS"=>"Rio Grande do Sul","RR"=>"Roraima","SC"=>"Santa Catarina","SE"=>"Sergipe","SP"=>"São Paulo","TO"=>"Tocantins");
		
		return $estados;
	}
	
	public static function is_uf($sigla)
	{
		$sigla = strtoupper($sigla);
		$estados = self::estados();
		return isset($estados[$sigla]);
	}
	
   public static function estado_por_extenso($sigla)
   {
   	 $estados = self::estados();
   	if(isset($estados[strtoupper($sigla)]))
   		return $estados[$sigla];
   	else
   		return "";
   }
   public static function estado_sigla_por_nome($estado)
   {
   	$estado = self::slugify($estado);
   	$siglas = array('acre' => 'AC','alagoas' => 'AL','amazonas' => 'AM','amapa' => 'AP','bahia' => 'BA','ceara' => 'CE','distrito-federal' => 'DF','espirito-santo' => 'ES','goias' => 'GO','maranhao' => 'MA','mato-grosso' => 'MT','mato-grosso-do-sul' => 'MS','minas-gerais' => 'MG','para' => 'PA','paraiba' => 'PB','parana' => 'PR','pernambuco' => 'PE','piaui' => 'PI','rio-de-janeiro' => 'RJ','rio-grande-do-norte' => 'RN','rondonia' => 'RO','rio-grande-do-sul' => 'RS','roraima' => 'RR','santa-catarina' => 'SC','sergipe' => 'SE','sao-paulo' => 'SP','tocantins' => 'TO');
   	if(isset($siglas[$estado]))
   		return $siglas[$estado];
   	else
   		return FALSE;
   }
   function MontarLink($texto)
	{
		if (!is_string($texto))
			return $texto;
	if(preg_match('@((https://)[a-zA-Z0-9./?&_\-#=;%]+)@i',$texto)){
			$texto=preg_replace('@((https://)[a-zA-Z0-9./?&_\-#=;%]+)@i', '<a target="_blank" href="$1">$1</a>', $texto);
	}
	if(preg_match('@[^(http://)]((www\.)[a-zA-Z0-9./?&_\-#=;%]+)@i',$texto)){
		$texto=preg_replace('@[^(http://)]((www\.)[a-zA-Z0-9./?&_\-#=;%]+)@i', ' http://$1', $texto);
	}
	if(preg_match('@((http://)[a-zA-Z0-9./?&_\-#=;%]+)@i',$texto)){
			$texto=preg_replace('@((http://)[a-zA-Z0-9./?&_\-#=;%]+)@i', '<a target="_blank" href="$1">$1</a>', $texto);
	}
		/*	  
		//$er = "/https:\/\/(www\.|.*?\/)?([a-zA-Z0-9]+|_|-)+(\.(([0-9a-zA-Z]|-|_|\/|\?|=|&)+))+/i";
		$er = "/https:\/\/(www\.|.*?\/)?([a-zA-Z0-9]+|_|-)+(\.(([0-9a-zA-Z]|-|_|\/|\?|=|&|%)+))+/i";
		preg_match_all($er, $texto, $match);
		foreach ($match[0] as $link)
		{
			$link = strtolower($link);
			$link_len = strlen($link);
			//troca "&" por "&amp;", tornando o link válido pela W3C
			$web_link = str_replace("&", "&amp;", $link);
			$texto = str_ireplace($link, "<a href=\"" . $web_link . "\" target=\"_blank\" title=\"". $web_link . "\" rel=\"nofollow\">". (($link_len > 60) ? substr($web_link, 0, 25) . "..." . substr($web_link, -15) : $web_link) . "</a>", $texto);
		}*/
		return $texto;
	}
	public static function estado_id($uf) 
	{
		if($uf == '1'){return 'AC';}
		elseif($uf == '2'){return 'AL';}
		elseif($uf == '3'){return 'AM';}
		elseif($uf == '4'){return 'AP';}
		elseif($uf == '5'){return 'BA';}
		elseif($uf == '6'){return 'CE';}
		elseif($uf == '7'){return 'DF';}
		elseif($uf == '8'){return 'ES';}
		elseif($uf == '9'){return 'GO';}
		elseif($uf == '10'){return 'MA';}
		elseif($uf == '11'){return 'MG';}
		elseif($uf == '12'){return 'MS';}
		elseif($uf == '13'){return 'MT';}
		elseif($uf == '14'){return 'PA';}
		elseif($uf == '15'){return 'PB';}
		elseif($uf == '16'){return 'PE';}
		elseif($uf == '17'){return 'PI';}
		elseif($uf == '18'){return 'PR';}
		elseif($uf == '19'){return 'RJ';}
		elseif($uf == '20'){return 'RN';}
		elseif($uf == '21'){return 'RO';}
		elseif($uf == '22'){return 'RR';}
		elseif($uf == '23'){return 'RS';}
		elseif($uf == '24'){return 'SC';}
		elseif($uf == '25'){return 'SE';}
		elseif($uf == '26'){return 'SP';}
		elseif($uf == '27'){return 'TO';}
	}
	public static function estado_uf($uf) 
	{
		if($uf == 'AC'){return 'Acre';}
		elseif($uf == 'AL'){return 'Alagoas';}
		elseif($uf == 'AM'){return 'Amazonas';}
		elseif($uf == 'AP'){return 'Amapá';}
		elseif($uf == 'BA'){return 'Bahia';}
		elseif($uf == 'CE'){return 'Ceará';}
		elseif($uf == 'DF'){return 'Distrito Federal';}
		elseif($uf == 'ES'){return 'Espírito Santo';}
		elseif($uf == 'GO'){return 'Goiás';}
		elseif($uf == 'MA'){return 'Maranhão';}
		elseif($uf == 'MG'){return 'Minas Gerais';}
		elseif($uf == 'MS'){return 'Mato Grosso do Sul';}
		elseif($uf == 'MT'){return 'Mato Grosso';}
		elseif($uf == 'PA'){return 'Pará';}
		elseif($uf == 'PB'){return 'Paraíba';}
		elseif($uf == 'PE'){return 'Pernambuco';}
		elseif($uf == 'PI'){return 'Piauí';}
		elseif($uf == 'PR'){return 'Paraná';}
		elseif($uf == 'RJ'){return 'Rio de Janeiro';}
		elseif($uf == 'RN'){return 'Rio Grande do Norte';}
		elseif($uf == 'RO'){return 'Rondônia';}
		elseif($uf == 'RR'){return 'Roraima';}
		elseif($uf == 'RS'){return 'Rio Grande do Sul';}
		elseif($uf == 'SC'){return 'Santa Catarina';}
		elseif($uf == 'SE'){return 'Sergipe';}
		elseif($uf == 'SP'){return 'São Paulo';}
		elseif($uf == 'TO'){return 'Tocantins';}
	}
	
	public static function is_data($data)
	{
		$partes = explode("/", $data);
		if(count($partes) != 3)
			return FALSE;
			
		// mes, dia, ano
		return checkdate($partes[1], $partes[0], $partes[2]);
	}

   public static function str_clean($texto, $remove='<>"\'%;)(&+') 
   {
      for ($i=0; $i < strlen($remove); $i++) { 
         $texto = str_replace(mb_substr($remove, $i, 1), "", $texto);
      }
      return $texto;
   }

   public static function to_utf8_mixed($dados)
   {
      $is_obj = false;
      if(is_object($dados))
      {
         $dados = (array) $dados;
         $is_obj = true;
      }
         
      foreach ($dados as $key => $value)
      {
         if(mb_detect_encoding($value, 'UTF-8', true) === false)
            $dados[$key] = utf8_encode($value);
         else
            $dados[$key] = $value;
      }

      if($is_obj)
         return (object) $dados;
      else
         return $dados;
   }

   public static function to_utf8($str)
   {
      if(mb_detect_encoding($str, 'UTF-8', true) === false)
         $str = utf8_encode($str);

      return $str;
   }

   public static function log($chave, $conteudo, $ip = false)
   {
      if( ! $ip)
         $ip = Model::factory('Visitante')->ip_cliente();
      
      $sql = DB::get('painel')->prepare("insert into site_log (hora, chave, conteudo, ip) values (:hora, :chave, :conteudo, :ip)");
      $sql->bindValue(':hora', date('Y:m:d H:i:s'));
      $sql->bindValue(':chave', $chave);
      $sql->bindValue(':conteudo', $conteudo);
      $sql->bindValue(':ip', $ip);
      return $sql->execute();
   }

   public static function isCEP($cep)
   {
      $padrao = '/[0-9]{5}\-[0-9]{3}/';
      return preg_match($padrao, $cep);
   }
}