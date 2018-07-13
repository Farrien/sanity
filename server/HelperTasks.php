<?
namespace Helper\Tasks;

class Tasks {
	private static $db;
	private static $tasksTable = 'hookups_managers';
	
	public function __construct() {
		global $pdo_db;
		self::$db = $pdo_db;
	}
	
	static public function getStatusID($taskId) {
		if (self::$db === null) new self();
		
		$sql = "SELECT person_b, worker_id, inspector_id, closed FROM " . self::$tasksTable . " WHERE id=?";
		$o1 = self::$db->prepare($sql);
		$o1->execute(array($taskId));
		$f1 = $o1->fetch(2);
		if ($f1['closed'] == 1) return 5;
		if ($f1['person_b'] == 0) return 0;
		if ($f1['worker_id'] == 0) return 1;
		if ($f1['inspector_id'] == 0) return 2;
		if ($f1['inspector_id'] > 0 && $f1['closed'] == 0) return 3;
		return 5;
	}
	
	static public function getStatus($taskId) {
		if (self::$db === null) new self();
		
		$sql = 'SELECT person_b, worker_id, inspector_id, closed FROM ' . self::$tasksTable . ' WHERE id=?';
		$o1 = self::$db->prepare($sql);
		$o1->execute(array($taskId));
		$f1 = $o1->fetch(2);
		if ($f1['closed'] == 1) return 'Завершено';
		if ($f1['person_b'] == 0) return 'В обработке';
		if ($f1['worker_id'] == 0) return 'Поиск исполнителя';
		if ($f1['inspector_id'] == 0) return 'Поиск проверяющего';
		if ($f1['inspector_id'] > 0 && $f1['closed'] == 0) return 'Проверка';
		return 'Завершено';
	}
	
	static public function TaskExists($taskId) {
		if (self::$db === null) new self();
		
		$sql = 'SELECT id FROM ' . self::$tasksTable . ' WHERE id=?';
		$q = self::$db->prepare($sql);
		$q->execute(array(
			$taskId
		));
		$f = $q->fetch(2);
		if ($f) return true;
		return false;
	}
}