<?php
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

namespace Helper;

class Parser {
	public function init() {
		
	}
	
	static public function GetSourceFromURL($url, $always_update = false) {
		$cURL = curl_init();
		curl_setopt_array($cURL, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => 2
		));
		$result = curl_exec($cURL); curl_close($cURL);
		return $result;
	}
}