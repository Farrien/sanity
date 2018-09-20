<?php
namespace Superior\Http;

class HeadersInterface {
	static private $header = '';
	static private $statusCode = '200';
	
	public function set($header) {
		self::$header = $_SERVER['SERVER_PROTOCOL'] . ' ' . $header;
	}
	
	public function setStatusCode($code) {
		self::$statusCode = $code;
	}
	
	public function getStatusCode() {
		return self::$statusCode;
	}
}