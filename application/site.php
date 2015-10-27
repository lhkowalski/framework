<?php

class Site extends ActiveRecord
{
	public static $_tableName = 'sites';
	public static $_tableFields = ['id', 'nome', 'slug', 'nomeCliente'];
	public static $_tablePrimaryKey = 'id';
}