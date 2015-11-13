<?php
class SiteController extends Controller
{
   public function index()
   {
      $canvas = new Resultado_Imagem('download.jpg');
      $img1 = new Resultado_Imagem('food.jpg');
      $img2 = new Resultado_Imagem('food2.jpg');

      $canvas->addImagem($img1, 100, 100);
      $canvas->addImagem($img2, 440, 0);
      $canvas->addImagem($img2, 440, 210);

      $canvas->mostrarResultado();
   }
}