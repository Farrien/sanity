<?
use Helper\Users\Users;

class AdminClass Extends BaseController {
	// permissions - who can change?
	private $taskEditPerms = array(
		2 => true
	);
	private $userPerms;
	
	public function __proto() {
		global $USER;
		$this->userPerms = $USER['privileges'];
		if ($this->taskEditPerms[$this->userPerms]) return true;
		return false;
	}
	
	public function ChangeUserHireStatement() {
		$target = intval($this->C_QUERY['target']);
		if (!$target) return false;
		$tp = Users::getAccessLvl($target);
		$sql = 'UPDATE people SET permissionGroup=? WHERE id=?';
		$q = $this->DB->prepare($sql);
		if ($tp == 1) {
			$q->execute(array(
				0,
				$target
			));
		} else {
			$q->execute(array(
				1,
				$target
			));
		}
		return true;
	}
	
	public function ChangeUserToWorker() {
		$target = intval($this->C_QUERY['target']);
		if (!$target) return false;
		$tp = Users::getAccessLvl($target);
		$sql = 'UPDATE people SET permissionGroup=? WHERE id=?';
		$q = $this->DB->prepare($sql);
		if ($tp == 4) {
			$q->execute(array(
				0,
				$target
			));
		} else {
			$q->execute(array(
				4,
				$target
			));
		}
		return true;
	}
}
?>