<?php

class Request
{
   protected $_method, $_content;

   public function __construct()
   {
      $this->_content = null;
      $this->_method = $_SERVER['REQUEST_METHOD'];
   }

   /**
    * Retorna o conteúdo da requisição. Útil para quando alguma entidade for enviada via PUT ou POST.
    */
   public function content()
   {
      if($this->_content === null)
      {
         $this->_content = file_get_contents("php://input");
      }
      
      return $this->_content;
   }

   public function jsonContent()
   {
      $content = $this->content();
      $jsonContent = json_decode($content);

      if(json_last_error() === JSON_ERROR_NONE)
      {
         return $jsonContent;
      }
      else
      {
         null;
      }
   }

   public function method()
   {  
      return $this->_method;
   }

   public function isPost()
   {
      return $this->_method === 'POST';
   }

   public function isGet()
   {
      return $this->_method === 'GET';
   }
}