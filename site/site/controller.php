<?php
class Site_Controller extends Controller
{
   public function index()
   {
      $template = new Template('site/views/index.php');
      return $template;
   }
}