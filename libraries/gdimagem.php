<?php

class GDImagem
{
   protected $resourceImagemGD;
   protected $largura;
   protected $altura;

   public function __construct($imagem = null)
   {
      if( ! file_exists($imagem))
         throw new Exception("The image doesn't exists!");
         
      $this->resourceImagemGD = imagecreatefromjpeg($imagem);
      list($this->largura, $this->altura) = getimagesize($imagem);
   }

   public function getLargura()
   {
      return $this->largura;
   }

   public function getAltura()
   {
      return $this->altura;
   }

   /*
    * Adiciona uma imagem
    */
   public function addImagem($objImagem, $destinoX = 0, $destinoY = 0)
   {
      $resultado = imagecopymerge($this->resourceImagemGD, 
         $objImagem->getResource(), 
         $destinoX, 
         $destinoY, 
         0, // src x
         0, // src y
         $objImagem->getLargura(), // src w
         $objImagem->getAltura(), // src h
         100); // pct

      if( ! $resultado)
         throw new Exception("Cannot add image!");
   }

   /*
    * Adiciona uma área de texto
    */
   public function addTexto($objTexto, $destinoX = 0, $destinoY = 0)
   {
      $textcolor = imagecolorallocate($this->resourceImagemGD, 255, 255, 255);

      // Write the string at the top left
      //$fonte = ROOT_DIR . '/fonts/arial.ttf';
      $fonte = 'C:\Windows\Fonts\Arial.ttf';
      imagettftext($this->resourceImagemGD, 20, 0, $destinoX, $destinoY, $textcolor, $fonte, $objTexto);
   }

   /*
    * Adiciona um retangulo de determinada cor a imagem
    */
   public function addRetangulo()
   {
   }


   public function mostrarResultado()
   {
      header('Content-type: image/jpg');
      imagejpeg($this->resourceImagemGD);
   }

   public function salvarResultado()
   {

   }

   public function getResource()
   {
      return $this->resourceImagemGD;
   }
}