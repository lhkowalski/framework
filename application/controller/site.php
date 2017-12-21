<?php

class Controller_Site extends Controller
{
   public function index()
   {
      echo $this->request->method();
      //return new Template('views/index.php');
   }
}