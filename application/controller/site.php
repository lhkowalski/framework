<?php

class Controller_Site extends Controller
{
   public function index()
   {
      return new Template('views/index.php');
   }

   public function outro()
   {
   	echo 'Agora vai';
   }

   public function lista()
   {
   	echo 'Agora vai';
   }
}