<?php

class Controller_Default extends Controller
{
   public function index()
   {
      echo $this->request->method() . ' request on default controller';
   }
}