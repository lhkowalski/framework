<?php

class Pagination
{
   public static function build($base, $total, $atual = 1)
   {
      $template = new Template('views/pagination.php');

      if($total > 15)
         $total = 15;

      $template->base = $base;
      $template->total = $total;
      $template->atual = $atual;
      return $template;
   }
}