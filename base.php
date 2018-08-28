<?php
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

namespace SN;

use Exception;

class Management {
	private $errorsCount;
	private $errorExplanations;
	
	function __construct() {
		$this->errorsCount = 0;
		$this->errorExplanations = [];
	}
	
	public function ext($moduleName) {
		global $USER;
		global $pdo_db;
		global $SN;
		$wn = mb_strtolower($moduleName) . '.php';
		$path = $_SERVER['DOCUMENT_ROOT'] . '/' . $wn;
		if (!file_exists($path)) {
			$this->AddErr();
			$this->ExplaneLastError(__CLASS__ . ': Extension "' . basename($moduleName) . '" can not be found.');
			return false;
		}
		return require_once $path;
	}
	
	public function template($templateName) {
		global $USER;
		global $pdo_db;
		$wn = mb_strtolower($templateName) . '.php';
		$path = $_SERVER['DOCUMENT_ROOT'] . '/templates/' . DESIGN_TEMPLATE . '/' . $wn;
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
		$SupportName = mb_strtolower($SupportName);
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
		$this->errorsCount += 1;
	}
	
	public function ExplainLastError($str = 'Undeclared explanation.') {
		$this->errorExplanations[$this->errorsCount] = $str;
	}
	
	public function GetErrors() {
		return $this->errorsCount;
	}
	
	public function PrintErrors() {
		global $lang;
		echo $lang['#SN_Errors_TotalCount'] . ' — ' . $this->errorsCount, "\n\r<br>";
		foreach ($this->errorExplanations as $k=>$v) {
			echo $v, "\n\r<br>";
		}
		return;
	}
}