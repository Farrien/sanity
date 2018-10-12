<?php
namespace Superior;

use Superior\Component\View;
use Superior\Http\HeadersInterface;

class Response {
	static public $Status;
	
	static public function View($path, Array $variables = []) {
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/public/' . $path)) {
			return new View($path, $variables);
		}
		static::Status()->setStatusCode(500);
		return false;
	}
	
	static public function Redirect($str = '') {
		$str = trim($str, '/');
		if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||  isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$protocol = 'https://';
		} else {
			$protocol = 'http://';
		}
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: ' . $protocol . $_SERVER['HTTP_HOST'] . '/' . $str);
		exit;
	}
	
	static public function Status() {
		if (is_null(static::$Status)) static::$Status = new HeadersInterface;
		return static::$Status;
	}
}