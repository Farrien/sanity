<?php
namespace Superior;

use Superior\Component\View;

class Response {
	
	static public function View($path, Array $variables = []) {
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/public/' . $path)) {
			return new View($path, $variables);
		}
		return [];
	}
}