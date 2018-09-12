<?php
namespace Superior;

use SN\Management as SN;
use Exception;
use Superior\Http\Queries;
use Superior\Http\Constructor;

class Request {
	static public $constructor;
	static public $requested_page = 'index';
	private $method;
	
	function __construct() {
		$this->method = strtolower($_SERVER['REQUEST_METHOD']);
		static::$constructor = $this->reg();
		if (isset($_REQUEST['p'])) {
			static::$requested_page = $_REQUEST['p'];
		}
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
		$cleanURI = Queries::QueryString();
		return $cleanURI;
	}
	
	public function r($row) {
		if (isset(static::$constructor->get()->$row) || property_exists(static::$constructor->get(), $row)) {
			return static::$constructor->get()->$row;
		} else {
			SN::NewErr();
			SN::ExplainLast('Request augmentation is missing. Trying to get properties will provide an error. Please use special methods to verify augmentation before using it.');
		}
		return false;
	}
	
	static public function Data() {
		return static::$constructor->get();
	}
	
	public function augments() {
		return static::$constructor->getAugments();
	}
	
	public function hasAugments() {
		return static::$constructor->isAugmentsPresent();
	}
	
	public function getCurrentPage() {
		return static::$requested_page;
	}
}