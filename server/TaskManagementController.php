<?
use Helper\Tasks\Tasks;
use Helper\Users\Users;

class TaskManagementClass Extends BaseController {
	private $task_id;
	private $f;
	// permissions - who can change?
	private $taskEditPerms = array(
		1 => true,
		2 => true
	);
	private $userPerms;
	
	public function __proto() {
		if (empty($this->CurrentUserID) || empty($this->C_QUERY['task_id'])) return false;
		$this->task_id = (int) $this->C_QUERY['task_id'];
		if (!Tasks::TaskExists($this->task_id)) return false;
		global $USER;
		$this->userPerms = $USER['privileges'];
		$q = $this->DB->prepare('SELECT person_a, person_b FROM hookups_managers WHERE id=?');
		$q->execute(array($this->task_id));
		$this->f = $q->fetch(2);
		if ($this->f) {
			return true;
		}
		return false;
	}
	
	private function isFree() {
		return !$this->f['person_b'];
	}
	
	private function hasPermission() {
		if ($this->taskEditPerms[$this->userPerms]) return true;
		return false;
	}

	public function EnterIntoTask() {
		if ($this->hasPermission() && $this->isFree()) {
			$sql = 'UPDATE hookups_managers SET person_b=? WHERE id=?';
			$q = $this->DB->prepare($sql);
			$q->execute(array(
				$this->CurrentUserID,
				$this->task_id
			));
			return true;
		}
		return false;
	}

	public function CloseTask() {
		if ($this->hasPermission()) {
			$sql = 'UPDATE hookups_managers SET closed=1, complete_date=? WHERE id=?';
			$q = $this->DB->prepare($sql);
			$q->execute(array(
				$_SERVER['REQUEST_TIME'],
				$this->task_id
			));
			return true;
		}
		return false;
	}

	public function SetWorker() {
		$worker = intval($this->C_QUERY['worker_id']);
		if (!$worker) return false;
		if ($this->hasPermission()) {
			$sql = 'UPDATE hookups_managers SET worker_id=? WHERE id=?';
			$q = $this->DB->prepare($sql);
			$q->execute(array(
				$worker,
				$this->task_id
			));
			return true;
		}
		return false;
	}

	public function unsetWorker() {
		if ($this->hasPermission()) {
			$sql = 'UPDATE hookups_managers SET worker_id=0 WHERE id=?';
			$q = $this->DB->prepare($sql);
			$q->execute(array($this->task_id));
			return true;
		}
		return false;
	}
	
	public function SetInspectionQuest() {
		if ($this->hasPermission()) {
			$reward = intval($this->C_QUERY['money']);
			if ($reward < 1) return false;
			$sub = intval($this->C_QUERY['subject']);
			if ($sub < 0) return false;
			$sql = 'INSERT INTO inspector_quests (hookup_id, subject_id, reward, added_time) VALUES (?, ?, ?, ?)';
			$q = $this->DB->prepare($sql);
			$q->execute(array(
				$this->task_id,
				$sub,
				$reward,
				$_SERVER['REQUEST_TIME']
			));
			return true;
		}
		return false;
	}

	public function FireManager() {
		if ($this->hasPermission()) {
			$sql = 'UPDATE hookups_managers SET person_b=0 WHERE id=?';
			$q = $this->DB->prepare($sql);
			$q->execute(array($this->task_id));
			return true;
		}
		return false;
	}

	public function NotifyClient() {
		if ($this->hasPermission()) {
			$targetPhone = Users::getLogin($f['person_a']);
			// Sending SMS notification to client
			include_once dirname(__DIR__) . '/outsource/smsc_api.php';
			send_sms($targetPhone, 'Ufaeyes. По Вашему заданию №' . $this->task_id . ' пришел ответ от менеджера.', 0, 0, 0, 0, 'UfaEyes');
			return true;
		}
		return false;
	}
}
?>