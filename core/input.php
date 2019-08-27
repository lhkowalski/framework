<?php

abstract class Input
{
	public $data, $errors;
	protected $inputData;

	public function __construct($inputData)
	{
		$this->inputData = $inputData;
		$this->data = [];
		$this->errors = [];
	}

	abstract function validate();
}