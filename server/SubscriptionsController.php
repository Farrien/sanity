<?

class SubscriptionsClass Extends BaseController {

	public function IncludeSubject() {
		$exist = self::DependencyExists($this->C_QUERY['id'], $this->CurrentUserID);
		if ($exist) {
			$sql = "UPDATE subjects_dependency SET active=1 WHERE subject_id=? AND owner_id=?";
			$o1 = $this->DB->prepare($sql);
			$o1->execute(array($this->C_QUERY['id'], $this->CurrentUserID));
			return true;
		} else {
			$sql = "INSERT INTO subjects_dependency (subject_id, owner_id, active) VALUES (?, ?, 1)";
			$o1 = $this->DB->prepare($sql);
			$o1->execute(array($this->C_QUERY['id'], $this->CurrentUserID));
			return true;
		}
		return false;
	}
	
	public function ExcludeSubject() {
		$exist = self::DependencyExists($this->C_QUERY['id'], $this->CurrentUserID);
		if ($exist) {
			$sql = "UPDATE subjects_dependency SET active=0 WHERE subject_id=? AND owner_id=?";
			$o1 = $this->DB->prepare($sql);
			$o1->execute(array($this->C_QUERY['id'], $this->CurrentUserID));
			return true;
		}
		return false;
	}
	
	private function IsVoteExist($id1, $id2) {
		$o1 = $this->DB->prepare("SELECT * FROM votes WHERE voter_id=? AND target_id=?");
		$o1->execute(array($id1, $id2));
		$a1 = $o1->fetch(PDO::FETCH_ASSOC);
		if ($a1 == false) return false;
		return true;
	}
	
	static public function DependencyExists($sub, $user) {
		$sql = "SELECT COUNT(*) FROM subjects_dependency WHERE subject_id=? AND owner_id=? LIMIT 1";
		global $pdo_db;
		$o1 = $pdo_db->prepare($sql);
		$o1->execute(array($sub, $user));
		$f1 = $o1->fetchColumn();
		if ($f1==1) return true;
		return false;
	}
}
?>