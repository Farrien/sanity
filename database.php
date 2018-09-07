<?php
use SN\Management as SN;

/*
try {
	$pdo_db = new PDO('mysql:host='.DATABASE_SETTING_HOSTNAME.';dbname='.DATABASE_SETTING_DBNAME.';charset=utf8;', DATABASE_SETTING_USER, DATABASE_SETTING_PASSWORD);
} catch (PDOException $e) {
	$SN->AddErr();
	$SN->ExplainLastError($e->getMessage());
}*/

$DatabaseParams = [
	'host'			=> DATABASE_SETTING_HOSTNAME,
	'port'			=> DATABASE_SETTING_HOSTPORT,
	'database'		=> DATABASE_SETTING_DBNAME,
	'user'			=> DATABASE_SETTING_USER,
	'password'		=> DATABASE_SETTING_PASSWORD,
];

new DB();
/* For old usage */
$pdo_db = DB::getPDO();

class DB {
	static private $db;
	
	function __construct() {
		$tdb = $this->CreateConnection();
		self::$db = $tdb;
	}
	
	private function CreateConnection() {
		try {
			$connection = new PDO('mysql:host='.DATABASE_SETTING_HOSTNAME.';dbname='.DATABASE_SETTING_DBNAME.';charset=utf8;', DATABASE_SETTING_USER, DATABASE_SETTING_PASSWORD);
			return $connection;
		} catch (PDOException $e) {
			SN::NewErr();
			SN::ExplainLast($e->getMessage());
			return false;
		}
	}
	
	static public function getPDO() {
		return self::$db;
	}
	
	static public function PDO() {
		return self::$db;
	}
}