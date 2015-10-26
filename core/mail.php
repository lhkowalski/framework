<?php

class Mail
{
   public static function send($destinatario, $assunto, $html)
   {
      if($destinatario and $assunto and $html)
      {
         $headers = "Content-type: text/html; charset=utf-8" . PHP_EOL;
         $headers.= "From: Bilheteria Digital <atendimento2@bilheteriadigital.com>" . PHP_EOL;
         $headers.= "Reply-To: atendimento2@bilheteriadigital.com.br";
         return mail($destinatario, $assunto, $html, $headers);
      }
      else
      {
         return FALSE;
      }
   }
   public static function send_smtp($destinatario, $assunto, $conteudo)
   {
   	require_once('class.phpmailer.php');
   
   	
   	$host = "mail.bilheteriadigital.com";
   	$mail = "atendimento2@bilheteriadigital.com";
   	$senha = "2015%";
   	 
   
   	$smtp = new PHPMailer();
   	$smtp->IsSMTP();
   
   	$smtp->Port = 587;
   
   	$smtp->Host = $host;
   	$smtp->SMTPAuth = TRUE;
	$smtp->CharSet  = "iso-8859-1";
   	$smtp->Username = $mail; /*usuario do servidor SMTP */
   	$smtp->Password = $senha; /* senha do usuario do servidor SMTP*/
   	$smtp->From = $mail;
   	$smtp->FromName = "Bilheteria Digital";
   
   	$smtp->AddAddress($destinatario);
   
   	$smtp->WordWrap = 50; // ATIVAR QUEBRA DE LINHA
   	$smtp->IsHTML(TRUE);
   	$smtp->Subject = $assunto;
   	$smtp->Body = $conteudo;
   
   	@ $retorno = $smtp->Send();
   	return $retorno;
   }
}