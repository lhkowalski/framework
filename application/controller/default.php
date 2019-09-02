<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class Controller_Default extends Controller
{
   public function index()
   {
   	$param = $this->request->query->get('name');
      $this->response = new JsonResponse(['req' => $param]);

      $this->response
	      ->setStatusCode(Response::HTTP_NOT_FOUND)
	      ->send();
   }
}