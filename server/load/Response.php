<?php
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

namespace Superior;

class Response {
	
	function __construct() {
		
	}
	
	 function execute() {
		return $this;
	}
}