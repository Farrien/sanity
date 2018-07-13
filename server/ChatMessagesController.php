<?
use Helper\Userthings\Userthings;
use Helper\Database as Database;
use Helper\Users as Users;

class ChatMessagesClass Extends BaseController {
	#private $topic_name;
	private $hookup_id;
	private $accessLevel;
	private $targetGroup;
	
	public function __proto() {
		# temporary lines for StartDiscussion |-|-|-|-| Rewrite to TaskManager
		if (!empty($this->C_QUERY['tel']) && !empty($this->C_QUERY['name']) && !empty($this->C_QUERY['zapros']) && !empty($this->C_QUERY['msg'])) return true;
		
		
		if (empty($this->C_QUERY['hook'])) return false;
		$this->hookup_id = (int) $this->C_QUERY['hook'];
		if ($this->chatExists()) {
			$this->accessLevel = Users\Users::getAccessLvl($this->CurrentUserID);
			if (($this->accessLevel == 1 || $this->accessLevel == 2) && isset($this->C_QUERY['receiverLvl'])) {
				$tG = $this->C_QUERY['receiverLvl'];
				if ($tG == 3 || $th == 4) $this->targetGroup = $tG;
			}
			return true;
		}
		return false;
	}
	
	private function chatExists() {
		$check = Database\SN_Database::rowExists('`hookups_managers`', array('id=' . $this->hookup_id));
		if ($check) return true;
		return false;
	}
	
	public function GetMessagesUltimateAccess() {
		$sql = 'SELECT person_a, person_b, worker_id, inspector_id FROM hookups_managers WHERE id=?';
		$t = $this->DB->prepare($sql);
		$t->execute(array($this->hookup_id));
		$f = $t->fetch(PDO::FETCH_ASSOC);
		
		$sql = 'SELECT *, (SELECT name FROM people WHERE id=sender_id) AS sender_name FROM messages WHERE receiver_hookup=?';
		
		if ($f['person_a'] == $this->CurrentUserID && $this->accessLevel == 0) {
			$sql .= ' AND vision_flag=0';
		} elseif ($this->accessLevel == 1) { #manager
			$sql .= ' AND (vision_flag=0 OR vision_flag=3 OR vision_flag=4)';
		} elseif ($this->accessLevel == 2) { #admin
			$sql .= ' AND (vision_flag=0 OR vision_flag=3 OR vision_flag=4)';
		} elseif ($f['inspector_id'] == $this->CurrentUserID && $this->accessLevel == 3) {
			$sql .= ' AND (vision_flag=3)';
		} elseif ($f['worker_id'] == $this->CurrentUserID && $this->accessLevel == 4) {
			$sql .= ' AND (vision_flag=4)';
		} else {
			return false;
		}

		# ORDER
		$sql .= ' ORDER BY msg_time DESC';
		$q = $this->DB->prepare($sql);
		$q->execute(array($this->hookup_id));
		while ($f2 = $q->fetch(PDO::FETCH_ASSOC)) {
			$j1['msgList'][] = array('sender'=> $f2['sender_name'], 'inner' => nl2br($f2['msg_inner']), 'for_order' => $f2['msg_time']);
		}
		if (isset($j1['msgList'])) return $j1;
		return $j['lvl'] = $this->accessLevel;
	}
	
	public function GetMessageHistory() {
		if (!empty($this->C_QUERY['hook']) && empty($this->C_QUERY['key'])) {
			$sql = "SELECT person_b FROM hookups_managers WHERE id=? AND closed=0";
			$q = $this->DB->prepare($sql);
			$q->execute(array($this->C_QUERY['hook']));
			$f = $q->fetch(PDO::FETCH_ASSOC);
			if ($f['person_b'] != 0) return false;
			$sql = "SELECT sender_id, receiver_hookup, msg_inner, msg_time, (SELECT name FROM people WHERE id=sender_id) AS sender_name FROM messages WHERE receiver_hookup=? AND vision_flag=0 ORDER BY msg_time ASC";
			$q = $this->DB->prepare($sql);
			$q->execute(array($this->C_QUERY['hook']));
			while ($f2 = $q->fetch(PDO::FETCH_ASSOC)) {
				$j1['msgList'][] = array('sender'=> $f2['sender_name'], 'inner' => nl2br($f2['msg_inner']), 'for_order' => $f2['msg_time']);
			}
			if (isset($j1['msgList'])) return $j1;
		}
		if (empty($this->C_QUERY['key'])) return false;
		$sql = "SELECT sender_id, receiver_hookup FROM messages WHERE receiver_hookup=? LIMIT 1";
		$o1 = $this->DB->prepare($sql);
		$o1->execute(array($this->C_QUERY['hook']));
		$f1 = $o1->fetch(PDO::FETCH_ASSOC);
		$gener = hash_hmac('md5', $f1['sender_id'] . '-' . $this->C_QUERY['hook'], 'SweetHarmony');
		if ($gener == $this->C_QUERY['key']) {
			$sql = "SELECT sender_id, receiver_hookup, msg_inner, msg_time, (SELECT name FROM people WHERE id=sender_id) AS sender_name FROM messages WHERE receiver_hookup=? AND vision_flag=0 ORDER BY msg_time ASC";
			$o2 = $this->DB->prepare($sql);
			$o2->execute(array($this->C_QUERY['hook']));
			
			while ($f2 = $o2->fetch(PDO::FETCH_ASSOC)) {
				$j1['msgList'][] = array('sender'=> $f2['sender_name'], 'inner' => nl2br($f2['msg_inner']), 'for_order' => $f2['msg_time'], 'im_id'=> $f2['sender_id']);
			}
			if (isset($j1['msgList'])) return $j1;
		}
		return false;
	}
	
	public function GetMessageHistoryBtwnManagerInspector() {
		if (empty($this->C_QUERY['hook']) || empty($this->C_QUERY['key'])) return false;
		$sql = "SELECT sender_id, receiver_hookup FROM messages WHERE receiver_hookup=?";
		$args = array(
			$this->C_QUERY['hook']
		);
		$o1 = $this->DB->prepare($sql);
		$o1->execute($args);
		$f1 = $o1->fetch(PDO::FETCH_ASSOC);
		$gener = hash_hmac('md5', $f1['sender_id'] . '-' . $this->C_QUERY['hook'], 'SweetHarmony');
		if ($gener == $this->C_QUERY['key']) {
			$sql = "SELECT sender_id, receiver_hookup, msg_inner, msg_time, (SELECT name FROM people WHERE id=sender_id) AS sender_name FROM messages WHERE receiver_hookup=? AND ((sender_id=? AND vision_flag=3) OR (sender_id=? AND vision_flag=3)) ORDER BY msg_time ASC";
			$o2 = $this->DB->prepare($sql);
			$o2->execute(array($this->C_QUERY['hook'], $this->CurrentUserID, $this->C_QUERY['specific_user']));
			
			while ($f2 = $o2->fetch(PDO::FETCH_ASSOC)) {
				$j1['msgList'][] = array('sender'=> $f2['sender_name'], 'inner' => nl2br($f2['msg_inner']), 'for_order' => $f2['msg_time']);
			}
			if (isset($j1['msgList'])) return $j1;
		}
		return false;
	}
	
	public function GetMessageHistoryBtwnManagerWorker() {
		if (empty($this->C_QUERY['hook']) || empty($this->C_QUERY['key'])) return false;
		$sql = "SELECT sender_id, receiver_hookup FROM messages WHERE receiver_hookup=?";
		$args = array(
			$this->C_QUERY['hook']
		);
		$o1 = $this->DB->prepare($sql);
		$o1->execute($args);
		$f1 = $o1->fetch(PDO::FETCH_ASSOC);
		$gener = hash_hmac('md5', $f1['sender_id'] . '-' . $this->C_QUERY['hook'], 'SweetHarmony');
		if ($gener == $this->C_QUERY['key']) {
			$sql = "SELECT sender_id, receiver_hookup, msg_inner, msg_time, (SELECT name FROM people WHERE id=sender_id) AS sender_name FROM messages WHERE receiver_hookup=? AND ((sender_id=? AND vision_flag=4) OR (sender_id=? AND vision_flag=4)) ORDER BY msg_time ASC";
			$o2 = $this->DB->prepare($sql);
			$o2->execute(array($this->C_QUERY['hook'], $this->CurrentUserID, $this->C_QUERY['specific_user']));
			
			while ($f2 = $o2->fetch(PDO::FETCH_ASSOC)) {
				$j1['msgList'][] = array('sender'=> $f2['sender_name'], 'inner' => nl2br($f2['msg_inner']), 'for_order' => $f2['msg_time']);
			}
			if (isset($j1['msgList'])) return $j1;
		}
		return false;
	}
	
	public function SendMessage() {
		if (empty($this->C_QUERY['sendingMessage']) || empty($this->C_QUERY['hook']) || empty($this->C_QUERY['key'])) return false;
		$text = prepareString($this->C_QUERY['sendingMessage']);
		$hookup_id = $this->C_QUERY['hook'];
		
		$sql = "SELECT sender_id, receiver_hookup FROM messages WHERE receiver_hookup=? LIMIT 1";
		$o1 = $this->DB->prepare($sql);
		$o1->execute(array($hookup_id));
		$f1 = $o1->fetch(PDO::FETCH_ASSOC);
		$gener = hash_hmac('md5', $f1['sender_id'] . '-' . $this->C_QUERY['hook'], 'SweetHarmony');
		if ($gener == $this->C_QUERY['key']) {
			if (!empty($this->CurrentUserID)) {
				$this->AddMessage($this->CurrentUserID, $hookup_id, 1, $text);
			} else {
				$this->AddMessage($f1['sender_id'], $hookup_id, 1, $text);
			}
			$j1['comments'] = 'successful';
			return $j1;
		}
		return false;
	}
	
	public function ManageSendMessage() {
		if (empty($this->C_QUERY['sendingMessage']) || empty($this->C_QUERY['hook']) || empty($this->C_QUERY['key'])) return false;
		$text = prepareString($this->C_QUERY['sendingMessage']);
		$hookup_id = $this->C_QUERY['hook'];
		
		$sql = "SELECT sender_id, receiver_hookup FROM messages WHERE receiver_hookup=? LIMIT 1";
		$o1 = $this->DB->prepare($sql);
		$o1->execute(array($hookup_id));
		$f1 = $o1->fetch(PDO::FETCH_ASSOC);
		$gener = hash_hmac('md5', $f1['sender_id'] . '-' . $this->C_QUERY['hook'], 'SweetHarmony');
		if ($gener == $this->C_QUERY['key']) {
			if (!empty($this->CurrentUserID)) {
				$this->AddMessage($this->CurrentUserID, $hookup_id, 1, $text);
			}
			$j1['comments'] = 'successful';
			return $j1;
		}
		return false;
	}
	
	public function ServiceCommunicateAdd() {
		if (empty($this->C_QUERY['sendingMessage']) || empty($this->C_QUERY['hook']) || empty($this->C_QUERY['key'])) return false;
		$text = prepareString($this->C_QUERY['sendingMessage']);
		$hookup_id = $this->C_QUERY['hook'];
		
		$sql = "SELECT sender_id, receiver_hookup FROM messages WHERE receiver_hookup=? LIMIT 1";
		$o1 = $this->DB->prepare($sql);
		$o1->execute(array($hookup_id));
		$f1 = $o1->fetch(PDO::FETCH_ASSOC);
		$gener = hash_hmac('md5', $f1['sender_id'] . '-' . $this->C_QUERY['hook'], 'SweetHarmony');
		if ($gener == $this->C_QUERY['key']) {
			$j1['comments'] = 'successful';
		} else {
			return false;
		}
		
		$variant = $this->C_QUERY['variant'];
		if (!empty($this->CurrentUserID)) {
			if ($variant == 'inspector') {
				$this->AddMessage($this->CurrentUserID, $hookup_id, 1, $text, 3);
			}
			if ($variant == 'worker') {
				$this->AddMessage($this->CurrentUserID, $hookup_id, 1, $text, 4);
			}
			return $j1;
		}
		
		return false;
	}

	public function StartDiscussion() {
		if (empty($this->C_QUERY['tel']) || empty($this->C_QUERY['name']) || empty($this->C_QUERY['zapros']) || empty($this->C_QUERY['msg'])) return false;
		$login = prepareString($this->C_QUERY['tel'], false);
		if (mb_strlen($login) < 1) return false;
		$newUserRow = NULL;
		$userID = NULL;
		if (!$this->CurrentUserID && !Userthings::CheckLoginExisting($login)) {
			$newUserRow = Userthings::AddNewUser($login, NULL, $this->C_QUERY['name'], '');
			if (!$newUserRow) return false;
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
		session_start();
		$_SESSION['id'] = $userID;
		$_SESSION['privileges'] = 0;
		setcookie("lgn", $login, $_SERVER['REQUEST_TIME'] + 172800, '/');
		setcookie("pw", $newUserRow['password'], $_SERVER['REQUEST_TIME'] + 172800, '/');
		
		# Checking for duplicates
		$preparedZapros = prepareString($this->C_QUERY['zapros']);
		$conditions = array(
			"person_a={$userID}",
			"topic='{$preparedZapros}'",
			'added_time > ' . ($_SERVER['REQUEST_TIME'] - 21600),
		);
		$checkDuplicate = Database\SN_Database::rowExists('`hookups_managers`', $conditions);
		if ($checkDuplicate) return false;
		
		# Inserting new task into db
		$sql = "INSERT INTO `hookups_managers` (`person_a`, `person_b`, `topic`, `added_time`) VALUES (?, ?, ?, ?)";
		$args = array(
			$userID,
			0,
			prepareString($this->C_QUERY['zapros']),
			$_SERVER['REQUEST_TIME'],
		);
		$o1 = $this->DB->prepare($sql);
		$o1->execute($args);
		$hookup_id = $this->DB->lastInsertId();
		
		# Inserting new message into table throw another method
		$this->AddMessage($userID, $hookup_id, 1, prepareString($this->C_QUERY['msg']));
		
		$j1['comments'] = 'successful';
		$j1['msg'] = prepareString($this->C_QUERY['msg']);
		$j1['connect'] = $hookup_id;
		$j1['dialog_key'] = hash_hmac('md5', $userID . '-' . $hookup_id, 'SweetHarmony');
		$j1['current_topic'] = prepareString($this->C_QUERY['zapros']);
		$j1['your_name'] = prepareString($this->C_QUERY['name']);
		$j1['phone_number'] = prepareString($this->C_QUERY['tel']);
		
		$j1['hook'] = $hookup_id;
		$j1['hook_key'] = hash_hmac('md5', $userID . '-' . $hookup_id, 'SweetHarmony');
		
		// Sending SMS notification
		include_once dirname(__DIR__) . '/outsource/smsc_api.php';
		send_sms(SMS_NOTIFICATION_RECEIVER_PHONE, 'Ufaeyes. Поступила новая заявка. №' . $hookup_id . '.', 0, 0, 0, 0, 'UfaEyes');
		return $j1;
	}
	
	private function AddMessage($a, $b, $c, $d, $e = 0) {
		# для вызова внутри
		$sql = "INSERT INTO `messages` (`sender_id`, `receiver_hookup`, `msg_type`, `msg_inner`, `vision_flag`, `msg_time`) VALUES (?, ?, ?, ?, ?, ?)";
		$args = array(
			$a,
			$b,
			$c,
			$d,
			$e,
			$_SERVER['REQUEST_TIME'],
		);
		$o2 = $this->DB->prepare($sql);
		$o2->execute($args);
		$lastID =$this->DB->lastInsertId();
		return $lastID;
	}
}
?>