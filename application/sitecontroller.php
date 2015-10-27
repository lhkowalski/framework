<?php
class SiteController extends Controller
{
   public function index()
   {
      $template = new Template('views/index.php');

      $template->sites = Site::find();

      return $template;
   }
}