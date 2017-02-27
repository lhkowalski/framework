<?php

/**
 * Padrões de nomenclatura
 * load -> carrega um objeto
 * find -> carregar varios objetos em uma coleção (mesmo que o resultado tenha 1 registro)
 * save -> decide entre update e insert com base no valor de $obj->$pk
 */ 
abstract class ActiveRecord
{
	public static $_tableName;
	public static $_tableFields;
	public static $_tablePrimaryKey;

	public function __construct()
	{
		foreach (static::$_tableFields as $field)
		{
			if( ! isset($this->$field))
			{				
				$this->$field = null;
			}
		}
	}

	public function save()
	{
		$primaryKey = static::$_tablePrimaryKey;
		if($this->{$primaryKey} !== null)
		{
			return $this->update();
		}
		else
		{
			$this->{$primaryKey} = $this->insert();
			return true;
		}
	}

	public function insert()
	{
		$strSQL = "insert into %s (%s) values (%s)";
		$tableName = static::$_tableName;

		$arrayFields = [];
		$arrayData = [];
		foreach (static::$_tableFields as $field)
		{
			if($field != static::$_tablePrimaryKey)
			{
				if(isset($this->$field))
				{
					$arrayFields[] = $field;
					$arrayData[$field] = $this->$field;
				}	
			}
		}
		$strBinders = ':'. implode(', :', $arrayFields);
		$strFields = implode(', ', $arrayFields);

		if(empty($strFields))
			throw new InvalidArgumentException("You must set the fields list");

		if($tableName === null or empty($tableName))
			throw new InvalidArgumentException("You must set the table name");

		$strSQL = sprintf($strSQL, $tableName, $strFields, $strBinders);

		return self::insertBySql($strSQL, $arrayData);
	}

	public function update()
	{
		$strSQL = "update %s set %s where %s limit 1";
		$tableName = static::$_tableName;

		$arrayFieldsAndBinders = [];
		$arrayData = [];
		foreach (static::$_tableFields as $field)
		{
			if(isset($this->$field))
			{
				if($field != static::$_tablePrimaryKey)
				{
					$arrayFieldsAndBinders[] = $field . ' = :' . $field;
				}

				$arrayData[$field] = $this->$field;
			}	
		}

		$strFieldsAndBinders = implode(', ', $arrayFieldsAndBinders);
		$strWhere = static::$_tablePrimaryKey . ' = :' . static::$_tablePrimaryKey;

		if(empty($strFieldsAndBinders))
			throw new InvalidArgumentException("You must set the fields list");

		if(empty($strWhere))
			throw new InvalidArgumentException("You must set the primary key name");

		if($tableName === null or empty($tableName))
			throw new InvalidArgumentException("You must set the table name");

		$strSQL = sprintf($strSQL, $tableName, $strFieldsAndBinders, $strWhere);

		return self::updateBySql($strSQL, $arrayData);
	}

	protected static function _buildDelete($whereClause = null)
	{
		$strSQL = "delete from %s %s";
		$tableName = static::$_tableName;

		if($tableName === null or empty($tableName))
			throw new InvalidArgumentException("You must set the table name");

		$whereClause = $whereClause === null ? '' : 'where '.$whereClause;

		return sprintf($strSQL, $tableName, $whereClause);
	}

	public function delete()
	{
		$primaryKey = static::$_tablePrimaryKey;

		if($this->{$primaryKey} === null or ! $this->{$primaryKey})
			throw new Exception("You must load the object before delete");

		$whereClause = $primaryKey . ' = ?';
		$strSQL = self::_buildDelete($whereClause);

		$bindValues = [$this->{$primaryKey}];

		return self::deleteBySql($strSQL, $bindValues);
	}

	public static function deleteAll($whereClause = null, $bindValues = null)
	{
		$strSQL = self::_buildDelete($whereClause);

		if($bindValues !== null and ! is_array($bindValues))
			$bindValues = [$bindValues]; // transformar em array

		return self::deleteBySql($strSQL, $bindValues);
	}

	protected static function _buildSelect($whereClause)
	{
		$strSQL = "select %s from %s %s";
		$strFields = implode(', ', static::$_tableFields);
		$tableName = static::$_tableName;

		if(empty($strFields))
			throw new InvalidArgumentException("You must set the fields list");

		if($tableName === null or empty($tableName))
			throw new InvalidArgumentException("You must set the table name");

		$whereClause = $whereClause === null ? '' : 'where '.$whereClause;

		return sprintf($strSQL, $strFields, $tableName, $whereClause);
	}

	public static function find($whereClause = null, $bindValues = null)
	{
		$strSQL = self::_buildSelect($whereClause);

		if($bindValues !== null and ! is_array($bindValues))
			$bindValues = [$bindValues]; // transformar em array

		return self::findBySql($strSQL, $bindValues);
	}

	public static function load($whereClause = null, $bindValues = null)
	{
		$strSQL = self::_buildSelect($whereClause) . ' limit 1';

		if($bindValues !== null and ! is_array($bindValues))
			$bindValues = [$bindValues]; // transformar em array

		return self::loadBySql($strSQL, $bindValues);
	}

	protected static function _buildCount($whereClause)
	{
		$strSQL = "select %s from %s %s";
		$tableName = static::$_tableName;

		if(empty(static::$_tablePrimaryKey))
			throw new InvalidArgumentException("You must set the primary key name");

		$strFields = "count(".static::$_tablePrimaryKey.") as total";

		if($tableName === null or empty($tableName))
			throw new InvalidArgumentException("You must set the table name");

		$whereClause = $whereClause === null ? '' : 'where '.$whereClause;

		return sprintf($strSQL, $strFields, $tableName, $whereClause);
	}

	public static function count($whereClause = null, $bindValues = null)
	{
		$strSQL = self::_buildCount($whereClause);

		if($bindValues !== null and ! is_array($bindValues))
			$bindValues = [$bindValues]; // transformar em array

		$result = self::loadBySql($strSQL, $bindValues);
		return $result->total;
	}

	/**
	 * Executa uma SQL via PDO e retorna o statement resultante.
	 */
	protected static function _executeSQL($strSQL, $bindValues = null)
	{
		if($bindValues !== null and ! is_array($bindValues))
			throw new InvalidArgumentException("$bindValues must be an array or null");

		$sql = DB::get()->prepare($strSQL);

		$result = false;
		if(is_array($bindValues) and count($bindValues) > 0)
		{
			$result = $sql->execute($bindValues);
		}
		else
		{
			$result = $sql->execute();
		}

		if( ! $result)
		{	
			throw new Exception("Problema ao executar SQL!");
		}

		return $sql;
	}

   /**
    * Executa um select, define a classe para fetch e retorna o objeto da consulta
    */
	protected static function _doSelect($strSQL, $bindValues = null)
	{
		$sql = self::_executeSQL($strSQL, $bindValues);
      $sql->setFetchMode(PDO::FETCH_CLASS, get_called_class());
      return $sql;
	}

	/**
	 * Retorna uma coleção de objetos que atendam aos criterios.
	 */ 
	public static function findBySql($strSQL, $bindValues = null)
	{
		$sql = self::_doSelect($strSQL, $bindValues);
      return $sql->fetchAll();
	}

	/**
	 * Retorna o primeiro objeto que atenda aos criterios.
	 */ 
	public static function loadBySql($strSQL, $bindValues)
	{
		$sql = self::_doSelect($strSQL, $bindValues);
      return $sql->fetch();
	}

	/**
	 * Remove todos os objetos que atendam aos criterios.
	 * Retorna o número de registros afetados.
	 */ 
	public static function deleteBySql($strSQL, $bindValues)
	{
		$sql = self::_executeSQL($strSQL, $bindValues);
      return $sql->rowCount();
	}

	/**
	 * Atualiza registros que atendam aos criterios.
	 * Retorna o número de linhas afetadas.
	 */ 
	public static function updateBySql($strSQL, $bindValues)
	{
		$sql = self::_executeSQL($strSQL, $bindValues);
      return $sql->rowCount();
	}

	/**
	 * Insere registros com os dados de bindValue.
	 * Retorna o ID do autoincremento.
	 */ 
	public static function insertBySql($strSQL, $bindValues)
	{
		$sql = self::_executeSQL($strSQL, $bindValues);
      return DB::get()->lastInsertId();
	}
}