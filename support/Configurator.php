<?php
namespace Helper;

class Configurator {
	static public function initConfig($path) {
		$ConfigINI = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/' . $path);
		foreach ($ConfigINI as $k=>$v) {
			define($k, $v);
		}
	}
}