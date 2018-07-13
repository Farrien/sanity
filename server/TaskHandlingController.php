<?
use Helper\Userthings\Userthings;
use Helper\Database\SN_Database;
use Helper\Users as Users;

use Task\Model as Task;

class TaskHandlingClass Extends BaseController {
	public function __proto() {
		return true;
		
		if (empty($this->CurrentUserID)) return false;
		if (empty($this->C_QUERY['task_id'])) return false;
		$this->task_id = (int) $this->C_QUERY['task_id'];
		$sql = 'SELECT person_b FROM hookups_managers WHERE id=?';
		$this->q = $this->DB->prepare($sql);
		$this->q->execute(array($this->task_id));
		$this->f = $this->q->fetch(2);
		if ($this->isExists()) return true;
		return false;
	}
	
	public function NewTask($arg1) {
	#	if (empty($this->C_QUERY['tel']) || empty($this->C_QUERY['name']) || empty($this->C_QUERY['zapros']) || empty($this->C_QUERY['msg'])) return false;
		$login = $this->C_QUERY['tel'];
		$newUserRow = NULL;
		$userID = NULL;
		if (!$this->CurrentUserID && !Userthings::CheckLoginExisting($login)) {
			$newUserRow = Userthings::AddNewUser($login, $login, $this->C_QUERY['name'], '');
		}
		$temporaryUserID = Userthings::GetIdentifierByLogin($login);
		if (is_null($this->CurrentUserID)) {
			if (is_null($newUserRow['id'])) {
				$userID = $temporaryUserID;
			} else {
				$userID = $newUserRow['id'];
			}
		} else {
			$userID = $this->CurrentUserID;
		}
		
		if (empty($_SESSION['id'])) {
			session_start();
			$_SESSION['id'] = $userID;
			$_SESSION['privileges'] = 0;
			setcookie("lgn", prepareString($login), time() + 172800, '/');
			setcookie("pw", $newUserRow['password'], time() + 172800, '/');
		}
		
		# Checking for duplicates
		$preparedZapros = prepareString($this->C_QUERY['zapros']);
		$conditions = array(
			'person_a=' . $userID,
			'topic=' . $preparedZapros,
			'added_time > ' . (time() - 21600),
		);
		$checkDuplicate = SN_Database::rowExists('`hookups_managers`', $conditions);
		if ($checkDuplicate) return false;
		
		# Inserting new task into db
	/*	$sql = "INSERT INTO `hookups_managers` (`person_a`, `person_b`, `topic`, `added_time`) VALUES (?, ?, ?, ?)";
		$args = array(
			$userID,
			0,
			prepareString($this->C_QUERY['zapros']),
			time(),
		);
		$o1 = $this->DB->prepare($sql);
		$o1->execute($args);
		$hookup_id = $this->DB->lastInsertId();*/
		
		$this->enable('Task');
		Task::createNewTask();
		
		# Inserting new message into table throw another method
	/*	$this->AddMessage($userID, $hookup_id, 1, prepareString($this->C_QUERY['msg']));
		
		$j1['comments'] = 'successful';
		$j1['msg'] = prepareString($this->C_QUERY['msg']);
		$j1['connect'] = $hookup_id;
		$j1['dialog_key'] = hash_hmac('md5', $userID . '-' . $hookup_id, 'SweetHarmony');
		$j1['current_topic'] = prepareString($this->C_QUERY['zapros']);
		$j1['your_name'] = prepareString($this->C_QUERY['name']);
		$j1['phone_number'] = prepareString($this->C_QUERY['tel']);
		
		$j1['hook'] = $hookup_id;
		$j1['hook_key'] = hash_hmac('md5', $userID . '-' . $hookup_id, 'SweetHarmony');*/
		return $j1;
	}
	/*
	private function AddMessage($a, $b, $c, $d, $e = 0) {
		# для вызова внутри
		$sql = "INSERT INTO `messages` (`sender_id`, `receiver_hookup`, `msg_type`, `msg_inner`, `vision_flag`, `msg_time`) VALUES (?, ?, ?, ?, ?, ?)";
		$args = array(
			$a,
			$b,
			$c,
			$d,
			$e,
			time(),
		);
		$o2 = $this->DB->prepare($sql);
		$o2->execute($args);
		$lastID =$this->DB->lastInsertId();
		return $lastID;
	}*/

}
?>