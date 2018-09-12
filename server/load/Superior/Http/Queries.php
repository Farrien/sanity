<?php
namespace Superior\Http;

class Queries {
	static public function QueryString($query = null) {
		if (is_null($query)) $query = $_SERVER['REQUEST_URI'];
		$cleanURI = preg_replace('/^\/([a-zA-Z]+)\/\?/i', '', $query);
		return $cleanURI;
	}
	
	static public function Query2Array($query = '') {
		parse_str(static::QueryString($query), $parsed_query);
		if (isset($parsed_query['id'])) $parsed_query['id'] = (int) $parsed_query['id'];
		return $parsed_query;
	}
}