<?php
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

class Permission {
	static private $permission_group;
	static private $has_permission = false;
	static private $group_collection;
	static private $user_groups = [
		0 => 'unauthorized',
		1 => 'authorized',
		2 => 'administrator',
	];
	
	static public function init($userGroup = 0) {
		try {
			self::setPermissionGroup($userGroup);
		} catch (Exception $e) {
			global $SN;
			$SN->AddErr();
			$SN->ExplainLastError($e->getMessage());
		}
	}
	
	static private function setPermissionGroup($given_group) {
		if (is_null($given_group)) $given_group = 0;
		if (is_int($given_group) && $given_group >= 0 && $given_group < count(self::$user_groups)) {
			self::$permission_group = $given_group;
		} else {
			throw new Exception('Given parameter can not be used.');
		}
	}
	
	static public function allow($group, String $path = '/', Closure $callback = NULL) {
		$comparing_path = preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']);
		if ($path != $comparing_path) return;
		
		if (is_int($group) && !is_array($group)) {
			$temp_value = $group;
			$group = [];
			$group[] = $temp_value;
			
		}
		foreach ($group AS $single) {
			if (self::$permission_group == $single) {
				self::$has_permission = true;
				break;
			}
		}
		
		/*
		|--------------------------------------------------------------------------
		| Prepared often useful functions
		|--------------------------------------------------------------------------
		*/
		function redirect($str = '/') {
			if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||  isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
				$protocol = 'https://';
			} else {
				$protocol = 'http://';
			}
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: ' . $protocol . $_SERVER['HTTP_HOST'] . $str);
			exit;
		}
		#--------------------------------------------------------------------------
		
		if (!self::$has_permission && $callback) {
			$query_vars = self::Query2Array($_SERVER['REQUEST_URI']);
			$imp = $callback($query_vars);
			if ($imp == false) {
				header('HTTP/1.0 403 Forbidden');
				exit;
			}
		}
	}
	
	static public function exclude($group, String $path = '/', Closure $callback = NULL) {
		# MAYBE NEED FIX?
		$comparing_path = preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']);
		if ($path != $comparing_path) return;
		
		if (is_int($group) && !is_array($group)) {
			$temp_value = $group;
			$group = [];
			$group[] = $temp_value;
			
		}
		foreach ($group AS $single) {
			if (self::$permission_group != $single) {
				self::$has_permission = true;
				break;
			}
		}
		
		/*
		|--------------------------------------------------------------------------
		| Prepared often useful functions
		|--------------------------------------------------------------------------
		*/
		function redirect($str = '/') {
			if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||  isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
				$protocol = 'https://';
			} else {
				$protocol = 'http://';
			}
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: ' . $protocol . $_SERVER['HTTP_HOST'] . $str);
			exit;
		}
		#--------------------------------------------------------------------------
		
		if (!self::$has_permission && $callback) {
			$query_vars = self::Query2Array($_SERVER['REQUEST_URI']);
			$imp = $callback($query_vars);
			if ($imp == false) {
				header('HTTP/1.0 403 Forbidden');
				exit;
			}
		}
	}
	
	static private function Query2Array($query_string) {
		$cleanURI = preg_replace('/^\/([a-zA-Z]+)\/\?/i', '', $query_string);
		parse_str($cleanURI, $parsed_query);
		if ($parsed_query['id']) $parsed_query['id'] = (int) $parsed_query['id'];
		return $parsed_query;
	}
}