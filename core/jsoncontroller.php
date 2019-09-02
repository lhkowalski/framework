<?php

use Symfony\Component\HttpFoundation\JsonResponse;

class JSONController extends Controller 
{
	public function __construct()
	{
		parent::__construct();

		$data = json_decode($this->request->getContent(), true);
      $this->request->request->replace(is_array($data) ? $data : array());

      $this->response = new JsonResponse();
	}
}