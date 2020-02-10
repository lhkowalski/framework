<?php

class JSONResponse implements ShowableResponse
{
    protected $_content, $_statusCode;

    public function __construct($content, $statusCode = 200)
    {
        $this->_content = $content;
        $this->_statusCode = $statusCode;
    }

    public function show()
    {
        http_response_code($this->_statusCode);
        header("Content-type: application/json; charset=utf-8");
        echo json_encode($this->_content);
    }
}