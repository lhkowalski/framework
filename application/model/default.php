<?php

class Model_Default extends ActiveRecord
{
	public static $_tableName = 'table';
	public static $_tableFields = ['f1', 'f2', '...'];

	public static $_tablePrimaryKey = 'id';
}
