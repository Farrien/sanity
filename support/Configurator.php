<?php
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

namespace Helper;

class Configurator {
	
	static public function basic() {
	}
	
	static public function initConfig($path) {
		$ConfigINI = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/' . $path);
		foreach ($ConfigINI as $k=>$v) {
			define($k, $v);
		}
	}
}