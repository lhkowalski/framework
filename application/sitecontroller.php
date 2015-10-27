<?php
class SiteController extends Controller
{
   public function index()
   {
      $cliente = Cliente::load('id = ?', 1);
      print_r($cliente);
      echo "<hr>";
      print_r($cliente->getSites()[0]->getCliente());
   }
}