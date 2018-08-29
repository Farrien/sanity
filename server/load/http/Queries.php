<?php
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

namespace Superior\Http;

class Queries {
	static public function QueryString($query = '') {
		$cleanURI = preg_replace('/^\/([a-zA-Z]+)\/\?/i', '', $query);
		return $cleanURI;
		
	}
	
	static public function Query2Array($query = '') {
		parse_str(static::QueryString($query), $parsed_query);
		if (isset($parsed_query['id'])) $parsed_query['id'] = (int) $parsed_query['id'];
		return $parsed_query;
	}
}