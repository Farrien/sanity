<?php
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

namespace Superior;

use Exception;
use Superior\Http\Queries;
use Superior\Http\Constructor;

class Request {
	static public $constructor;
	private $method;
	
	function __construct() {
		$this->method = strtolower($_SERVER['REQUEST_METHOD']);
		static::$constructor = $this->reg();
	}
	
	private function reg() {
		return new Constructor($this, $_REQUEST);
	}
	
	public function method() {
		return $this->method;
	}
	
	public function isMethod($method) {
		if ($this->method == $method) return true;
		return false;
	}
	
	public function url() {
		$cleanURI = Queries::QueryString($_SERVER['REQUEST_URI']);
		return $cleanURI;
	}
	
	public function r($row) {
		$answer = false;
		try {
			if (isset(static::$constructor->get()->$row) || property_exists(static::$constructor->get(), $row)) {
				$answer = static::$constructor->get()->$row;
			}
		} catch (Exception $e) {
			$SN->AddErr();
		}
		return $answer;
	}
	
	static public function Data() {
		return static::$constructor->get();
	}
	
	public function augments() {
		return static::$constructor->getAugments();
	}
}