<?php

class Pagination
{
   public static function build($base, $total, $atual = 1)
   {
      $itens = array();
      
      for($i = 1; $i <= $total; $i++)
      {
         $class = "link-pagina";
         if($i == $atual)
         {
            $class .= " link-pagina-atual";
         }
        // $itens[] = "<a class='$class' href='{$base}{$i}'>$i</a>";
      }

      if($atual == 1)
      {
         $anterior = "<span class='link-pagina'>&laquo; Anterior</span> ";
         if($total > 1)
            $proxima = " <a class='link-pagina' href='{$base}2'>Próxima &raquo;</a>";
         else
            $proxima = " <span class='link-pagina'>Próxima &raquo;</span>";
      }
      else
      {
         $anterior = "<a class='link-pagina' href='$base".($atual-1)."'>&laquo; Anterior</a> ";
         if($atual >= $total)
            $proxima = " <span class='link-pagina'>Próxima &raquo;</span>";
         else
            $proxima = " <a class='link-pagina' href='{$base}".($atual+1)."'>Próxima &raquo;</a>";
      }
      
      return $anterior.implode(" ", $itens).$proxima;
   }
}