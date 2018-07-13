<?

class GroupManagementClass Extends BaseController {

	public function __proto() {
		return true;
	}
	
	public function GetAllWorkers() {
		$q = $this->DB->query('SELECT id, name FROM people WHERE permissionGroup=4 ORDER BY name');
		if (!$q) return false;
		$j['list'] = array();
		while ($f = $q->fetch(2)) {
			$j['list'][] = array(
				'id' => $f['id'],
				'name' => $f['name'],
			);
		}
		return $j;
	}
}
?>