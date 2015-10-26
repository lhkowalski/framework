<?php 

class Recaptcha
{
   static $url = 'https://www.google.com/recaptcha/api/siteverify';
   static $secret = '6Le6aQ0TAAAAAFrJhaQ95L39oHu8BktKhxbfetpo';

   /**
    * Executa a consulta do g_recaptcha_response no serviço do ReCaptcha
    * para conferir se o desafio foi resolvido.
    * @param string $g_recaptcha_response a string preenchida pelo Recaptcha no frontend
    * @param string $remote_ip o ip do cliente
    * @return boolean true|false em caso de sucesso ou falha, respectivamente
    */
   public static function validar($g_recaptcha_response, $remote_ip)
   {
      $dados_requisicao = array(
         'secret'   => self::$secret,
         'response' => $g_recaptcha_response,
         'remoteip' => $remote_ip,
      );

      $content = http_build_query($dados_requisicao);
      $context = stream_context_create(array(
         'http' => array(
            'method'  => 'POST',
            'content' => $content,
            'timeout' => 120, 
         )
      ));

      $str_resultado = file_get_contents(self::$url, NULL, $context);
      $json_resultado = json_decode($str_resultado);

      return $json_resultado->success;
   }
}