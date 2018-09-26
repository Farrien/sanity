<?php
namespace Helper;

class Wallet {
	private static $db;
	
	public function __construct() {
		global $pdo_db;
		self::$db = $pdo_db;
	}
	
	static public function summary($id) {
		if (is_null(self::$db)) new self();
		$sql = 'SELECT SUM(IF(change_type=0, IFNULL(amount, 0), - IFNULL(amount, 0))) AS summary FROM wallet_history WHERE target_id=?';
		$q = self::$db->prepare($sql);
		$q->execute(array($id));
		$f = $q->fetch(2);
		$sum = $f['summary'] ? $f['summary'] : 0;
		return $sum;
	}
	
	static public function lastTransactions($id) {
		if (is_null(self::$db)) new self();
		$sql = 'SELECT id, change_type, amount FROM wallet_history WHERE target_id=?';
		$q = self::$db->prepare($sql);
		$q->execute(array($id));
		$list = array();
		while ($f = $q->fetch(2)) {
			$list[] = $f;
		}
		return $list;
	}
}