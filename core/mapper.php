<?php

/**
 * Padrões de nomenclatura
 * load -> carrega um objeto
 * find -> carregar varios objetos em uma coleção (mesmo que o resultado tenha 1 registro)
 * save -> decide entre update e insert com base no valor de $obj->$pk
 */ 
abstract class Mapper
{
	protected $primary_key = 'id';
	protected $table = 'table';

	/**
	 * Carrega um registro com base em um valor de chave primária
	 */
	public function loadByPK();

	/**
	 * Carrega um registro com base nos valores de um ou mais campos
	 */
	public function loadByFields();

	/**
	 * Carrega uma lista de registros com base nos valores de um ou mais campos
	 */
	public function findByFields();

	/**
	 * Apaga um registro com base em um valor de chave primária
	 */
	public function deleteByPK();

	/**
	 * Atualiza o objeto no banco de dados
	 */
	public function update();

	/**
	 * Insere o objeto no banco de dados
	 */
	public function insert();

	/**
	 * Salva o objeto no banco de dados, decidindo entre insert e update,
	 * com base no valor do campo sinalizado como PK
	 */
	public function save($obj)
	{
		if($obj->{$this->$primary_key} != null)
			$this->insert($obj)

	}

	/**
	 * As funções a seguir podem ser usadas diretamente e também são usadas pelas anteriores
	 */

	public function findBySql();
	public function loadBySql();
	public function deleteBySql();
	public function updateBySql();
	public function insertBySql();
}