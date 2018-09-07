<?php

namespace SN;

use Exception;

class Management {
	private static $errorsCount;
	private static $errorExplanations;
	
	function __construct() {
		static::$errorsCount = 0;
		static::$errorExplanations = [];
	}
	
	public function ext($moduleName) {
		global $USER;
		global $pdo_db;
		global $SN;
		$path = $_SERVER['DOCUMENT_ROOT'] . '/' . $moduleName . '.php';
		if (!file_exists($path)) {
			$this->AddErr();
			$this->ExplainLastError(__CLASS__ . ': Extension "' . basename($moduleName) . '" can not be found.');
			return false;
		}
		return require_once $path;
	}
	
	public function template($templateName) {
		global $USER;
		global $pdo_db;
		$path = $_SERVER['DOCUMENT_ROOT'] . '/templates/' . DESIGN_TEMPLATE . '/' . $templateName . '.php';
		if (!file_exists($path)) return false;
		return require_once $path;
	}
	
	public function helper($helperName) {
		try {
			$file = $this->FindHelper($helperName);
			if ($file) {
				global $USER;
				global $pdo_db;
				require_once $file;
			}
		} catch (Exception $e) {
			$this->AddErr();
			$this->ExplainLastError($e->getMessage());
		}
	}
	
	private function FindHelper($SupportName) {
		$path = $_SERVER['DOCUMENT_ROOT'] . '/support/' . $SupportName . '.php';
		if (!file_exists($path)) {
			throw new Exception(__CLASS__ . ' — Support file "' . basename($SupportName) . '" not found.');
		}
		return $path;
	}
	
	public function widget($widgetName) {
		global $USER;
		global $pdo_db;
		$wn = mb_strtolower($widgetName) . '.php';
		$path = $_SERVER['DOCUMENT_ROOT'] . '/templates/' . DESIGN_TEMPLATE . '/widgets/' . $wn;
		if (!file_exists($path)) return false;
		require_once $path;
	}
	
	public function register_request() {
		global $USER;
		global $pdo_db;
		$q = $pdo_db->prepare('INSERT INTO app_stats (i_ip, s_request_script, s_request_options, i_request_time, i_userid) VALUES(?, ?, ?, ?, ?)');
		$q->execute(array(
			$_SERVER['REMOTE_ADDR'],
			$_SERVER['PHP_SELF'],
			$_SERVER['QUERY_STRING'],
			$_SERVER['REQUEST_TIME'],
			$USER['id']
		));
	}
	
	public function RegisterScriptDuration() {
		global $pdo_db;
		global $ScriptStartTime;
		$mt = microtime(true);
		$d = $mt - $ScriptStartTime;
		if ($d >= 0.75 && $pdo_db) {
			$q = $pdo_db->prepare('INSERT INTO app_script_length_stats (s_request, s_mt, i_request_time) VALUES(?, ?, ?)');
			$q->execute(array(
				$_SERVER['PHP_SELF'] . ' -- ' . $_SERVER['QUERY_STRING'],
				$d,
				$_SERVER['REQUEST_TIME']
			));
		}
		/*
		Уведомления администратора при серьезном замедлении (при помощи SMS может даже?!)
		if ($d >= 3.14) {
			
		}
		*/
	}
	
	public function AddErr() {
		static::NewErr();
	}
	
	static public function NewErr() {
		static::$errorsCount += 1;
	}
	
	public function ExplainLastError($str = 'Undeclared explanation.') {
		static::ExplainLast($str);
	}
	
	static public function ExplainLast($str = 'Undeclared explanation.') {
		static::$errorExplanations[static::$errorsCount] = $str;
	}
	
	public function GetErrors() {
		return static::$errorsCount;
	}
	
	public function PrintErrors() {
		global $lang;
		echo '<div style="font-family: monospace;">';
		echo $lang['#SN_Errors_TotalCount'] . ' — ' . static::$errorsCount, "\n\r<br>";
		foreach (static::$errorExplanations as $k=>$v) {
			echo "[$k] ", $v, "\n\r<br>";
		}
		echo '</div>';
		return;
	}
}