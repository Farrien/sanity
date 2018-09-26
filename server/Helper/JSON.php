<?php
namespace Helper;

class JSON {
	static public function isValidJSON($string) {
		return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false;
	}
	
	/*
	$data = json_decode($json_string);
	if (is_null($data)) {
		die("Something dun gone blowed up!");
	}
	*/
}