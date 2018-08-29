<?php
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

namespace Superior;

class Constructor {
	public $request;
	
	function __construct(Request $object, Array $request_array) {
	#	remove a router's helper
		unset($request_array['p']);
		
		$this->request = (object) $request_array;
	}
	
	public function get() {
		return $this->request;
	}

}