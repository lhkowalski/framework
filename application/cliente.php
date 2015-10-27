<?php

class Cliente extends ActiveRecord
{
	public static $_tableName = 'clientes';
	public static $_tableFields = ['id', 'nome', 'email'];
	public static $_tablePrimaryKey = 'id';

   protected $listaSites = null;

   public function getSites()
   {
      if($this->listaSites === null)
      {
         $this->listaSites = Site::find('clienteId = ?', $this->id);
      }

      return $this->listaSites;
   }
}