<?
use Helper\Userthings as Userthings;
use Helper\Database as Database;
use Helper\Users as Users;

class WorkersClass Extends BaseController {
	private $worker;

	public function __proto() {
		$this->worker = (int) $this->C_QUERY['worker_id'];
		if (empty($this->worker)) $this->worker = $this->CurrentUserID;
	}
	
	public function GetWorkerInfo() {
		$j['name'] = Users\Users::getName($this->worker);
		$j['phone_num'] = Users\Users::getLogin($this->worker);
		$j['subjects'] = $this->GetWorkerSubjects();
		$j['company'] = $this->GetWorkerCompany()['company_name'] ?: 'Нет';
		return $j;
	}
	
	public function GetWorkerSubjects() {
		$q = $this->DB->prepare('SELECT subject_id, (SELECT subject_name FROM subjects WHERE id=subject_id) AS subject_name FROM subjects_dependency WHERE owner_id=? AND active=1 ORDER BY subject_name');
		$check = $q->execute(array($this->worker));
		if (!$check) return false;
		$j = array();
		while ($f = $q->fetch(2)) {
			$j[] = array(
				'sub' => $f['subject_id'],
				'name' => $f['subject_name'],
			);
		}
		return $j;
	}
	
	public function GetWorkerCompany() {
		$q = $this->DB->prepare('SELECT company_name FROM workers_companies WHERE worker_id=?');
		$check = $q->execute(array($this->worker));
		$f = $q->fetch(2);
		if (!$f || $f['company_name'] == NULL) return false;
		return $f;
	}
}
?>