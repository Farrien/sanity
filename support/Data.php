<?php
namespace Helper;

class Database {
	
	static public function rowExists($table, $conditions) {
		global $pdo_db;
		if (count($conditions) < 1) return false;
		$sql = 'SELECT COUNT(*) FROM ' . $table . ' WHERE id!=0';
		foreach ($conditions as $v) {
			$sql .= ' AND ' . $v;
		}
		$sql .= " LIMIT 1";
		$o1 = $pdo_db->prepare($sql);
		$o1->execute();
		$f1 = $o1->fetchColumn();
		if ($f1 > 0) {
			return true;
		}
		return false;
	}
}