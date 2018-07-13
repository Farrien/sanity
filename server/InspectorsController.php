<?
use Helper\Userthings as Userthings;
use Helper\Database as Database;
use Helper\Users as Users;

class InspectorsClass Extends BaseController {
	private $ispec;

	public function __proto() {
		$this->ispec = (int) $this->C_QUERY['target_id'];
		if (empty($this->ispec)) $this->ispec = $this->CurrentUserID;
	}
	
	public function GetInfo() {
		$j['name'] = Users\Users::getName($this->ispec);
		$j['phone_num'] = Users\Users::getLogin($this->ispec);
		$j['tasks'] = $this->GetCurrentTasks();
		return $j;
	}
	
	public function GetCurrentTasks() {
		$sql = 'SELECT hm.topic, hm.person_b, (SELECT login, name FROM people WHERE id=hm.person_b) UNION (SELECT login, name FROM people WHERE id=hm.person_a) FROM hookups_managers hm, people p WHERE hm.inspector_id=?';
		$sql = 'SELECT t.id, t.topic, w1.login AS topic_starter_phone, w2.name AS manager_name FROM hookups_managers as t LEFT JOIN people as w1 ON (w1.id = t.person_a) LEFT JOIN people as w2 ON (w2.id = t.person_b) WHERE t.inspector_id=? AND t.closed=0';
		$q = $this->DB->prepare($sql);
		$check = $q->execute(array($this->ispec));
		if (!$check) return false;
		$j = array();
		while ($f = $q->fetch(2)) {
			$j[] = array(
				'topic' => $f['topic'],
				'manager' => $f['manager_name'],
				'client' => $f['topic_starter_phone'],
			);
		}
		return $j;
	}
}
?>