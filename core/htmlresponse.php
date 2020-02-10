<?php

class HtmlResponse implements ShowableResponse
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
        header('Content-Type: text/html; charset=utf-8');
        echo $this->_content;
    }
}