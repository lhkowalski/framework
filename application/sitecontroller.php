<?php

class SiteController extends Controller
{
   public function index()
   {
      echo $this->request->method();
      //return new Template('views/index.php');
   }
}