<?php

class HTTP
{
	public static function notFound()
	{
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
	}

	public static function internalError()
	{
		header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error");
	}

	public static function seeOther($url = false)
	{
		header($_SERVER["SERVER_PROTOCOL"]." 303 See Other");
		if($url)
			header("Location: $url");
	}

	public static function found($url = false)
	{
		header($_SERVER["SERVER_PROTOCOL"]." 302 Found");
		if($url)
			header("Location: $url");
	}

	public static function moved($url = false)
	{
		header($_SERVER["SERVER_PROTOCOL"]." 301 Mover Permanently");
		if($url)
			header("Location: $url");
	}
}