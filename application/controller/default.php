<?php

class Controller_Default extends Controller
{
   public function index()
   {
      $message = $this->request->method() . ' request on default controller';
      echo $this->response->json(['message' => $message]);
   }
}