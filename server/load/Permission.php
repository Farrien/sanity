<?php
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

#namespace Superior;

use Superior\Http\Queries;

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
		#	at first nobody has access to this path
		self::$has_permission = false;
		
		$comparing_path = preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']);
		if ($path != $comparing_path) return;
		
		
		if (is_int($group) && !is_array($group)) {
			$temp_value = $group;
			$group = [];
			$group[] = $temp_value;
		}
		
		foreach ($group AS $k=>$v) {
			if (self::$permission_group == $v) {
				self::$has_permission = true;
				break;
			}
		}
		
		if (!self::$has_permission) {
			if ($callback) {
				$query_vars = Queries::Query2Array($_SERVER['REQUEST_URI']);
				$imp = $callback($query_vars);
				if ($imp == false) {
					header('HTTP/1.0 403 Forbidden');
					exit;
				}
			} else {
				header('HTTP/1.0 403 Forbidden');
				exit;
			}
		}
		/*
		==========================================================
		======================= ALLOW END ========================
		==========================================================
		*/
	}
	
	static public function exclude($group, String $path = '/', Closure $callback = NULL) {
		#	at first all groups have access to this path
		self::$has_permission = true;
		
		# MAYBE NEED FIX?
		$comparing_path = preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']);
		if ($path != $comparing_path) return;
		
		if (is_int($group) && !is_array($group)) {
			$temp_value = $group;
			$group = [];
			$group[] = $temp_value;
		}
		
		foreach ($group AS $k=>$v) {
			if (self::$permission_group == $v) {
				self::$has_permission = false;
				break;
			}
		}
		
		if (!self::$has_permission) {
			if ($callback) {
				$query_vars = Queries::Query2Array($_SERVER['REQUEST_URI']);
				$imp = $callback($query_vars);
				if ($imp == false) {
					header('HTTP/1.0 403 Forbidden');
					exit;
				}
			} else {
				header('HTTP/1.0 403 Forbidden');
				exit;
			}
		}
		/*
		==========================================================
		====================== EXCLUDE END =======================
		==========================================================
		*/
		
		/* backup
		foreach ($group AS $k=>$single) {
			echo 'Group  #' . $single;
			if (self::$permission_group != $single) {
				self::$has_permission = true;
				echo ' - orientir has permission', "<br/>";
				break;
			}
			echo ' - orientir fail', "<br/>";
		}
		
		if (!self::$has_permission && $callback) {
			echo ' - doing callback', "<br/>";
			$query_vars = Queries::Query2Array($_SERVER['REQUEST_URI']);
			$imp = $callback($query_vars);
			if ($imp == false) {
				header('HTTP/1.0 403 Forbidden');
				exit;
			}
		}*/
	}
	
	/*
	static private function Query2Array($query_string) {
		$cleanURI = preg_replace('/^\/([a-zA-Z]+)\/\?/i', '', $query_string);
		parse_str($cleanURI, $parsed_query);
		if ($parsed_query['id']) $parsed_query['id'] = (int) $parsed_query['id'];
		return $parsed_query;
	}*/
}