<?php

class Site extends ActiveRecord
{
	public static $_tableName = 'sites';
	public static $_tableFields = ['id', 'nome', 'slug', 'clienteId'];
	public static $_tablePrimaryKey = 'id';

   protected $objCliente = null;

   public function getCliente()
   {
      if($this->objCliente === null)
      {
         $this->objCliente = Cliente::load('id = ?', $this->clienteId);
      }

      return $this->objCliente;
   }
}