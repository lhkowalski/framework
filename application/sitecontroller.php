<?php

class SiteController extends Controller
{
   public function index()
   {
      return new Template('views/index.php');
   }
}