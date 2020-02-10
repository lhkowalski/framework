<?php

class Controller_Site extends Controller
{
   public function index()
   {
      //$template = new Template('views/index.php');
      //return $template;
      //return new HtmlResponse($template->render(), 404);
      return new JSONResponse(['nome' => "Luiz"], 400);
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