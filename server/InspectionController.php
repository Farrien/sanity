<?
use Helper\Tasks\Tasks;

class InspectionClass Extends BaseController {
	// permissions - who can change?
	private $taskEditPerms = array(
		3 => true
	);
	private $userPerms;
	private $quest;
	private $hookup;
	
	public function __proto() {
		if (empty($this->CurrentUserID)) return false;
		global $USER;
		$this->userPerms = $USER['privileges'];
		
		$this->C_QUERY['quest_id'] = (int) $this->C_QUERY['quest_id'];
		
		if (!empty($this->C_QUERY['quest_id'])) {
			$q = $this->DB->prepare('SELECT hookup_id, inspector_id FROM inspector_quests WHERE closed=0 AND id=?');
			$q->execute(array(
				$this->C_QUERY['quest_id']
			));
			$this->quest = $q->fetch(2);
			if (!$this->quest) return false;
		}
		
		if ($this->quest && $this->quest['hookup_id'] && Tasks::TaskExists($this->quest['hookup_id'])) {
			$q = $this->DB->prepare('SELECT inspector_id FROM hookups_managers WHERE closed=0 AND id=?');
			$q->execute(array(
				$this->quest['hookup_id']
			));
			$this->hookup = $q->fetch(2);
			if (!$this->hookup) return false;
		}
		return true;
	}
	
	private function isHookupFree() {
		if (!$this->hookup['inspector_id']) return true;
		return false;
	}
	
	private function isQuestFree() {
		if (!$this->quest['inspector_id']) return true;
		return false;
	}
	
	private function hasPermission() {
		return $this->taskEditPerms[$this->userPerms];
	}

	public function EnterIntoTask() {
		if ($this->hasPermission() && $this->isQuestFree() && $this->isHookupFree()) {
			$q = $this->DB->prepare('UPDATE hookups_managers SET inspector_id=? WHERE id=?');
			$q->execute(array(
				$this->CurrentUserID,
				$this->quest['hookup_id']
			));
			$q = $this->DB->prepare('UPDATE inspector_quests SET inspector_id=? WHERE id=?');
			$q->execute(array(
				$this->CurrentUserID,
				$this->C_QUERY['quest_id']
			));
			$j['taskID'] = $this->quest['hookup_id'];
			return $j;
		}
		return false;
	}
}
?>