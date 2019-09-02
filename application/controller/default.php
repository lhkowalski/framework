<?php

use Symfony\Component\HttpFoundation\Response;

class Controller_Default extends JSONController
{
   public function index()
   {
   	$data = $this->request->request->all();
   	
   	$usuario = ['nome' => "Luiz Kowalski"];

      $this->response
      	->setData($usuario)
	      ->setStatusCode(Response::HTTP_OK)
	      ->send();
   }
}