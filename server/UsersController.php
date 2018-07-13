<?
use Helper\Users\Users;

class UsersClass Extends BaseController {

	public function __proto() {
		return true;
	}
	
	public function GetUsersList() {
		# Поиск по логину/телефону
		if (isset($this->C_QUERY['strLogin'])) $sLogin = prepareString($this->C_QUERY['strLogin']);
		$rule1 = '';
		if (isset($sLogin) && mb_strlen($sLogin) > 0) {
			$rule1 = ' AND login LIKE "%' . $sLogin . '%"';
		}
		
		# Поиск по имени и/или фамилии
		if (isset($this->C_QUERY['strNames'])) $sNames = prepareString($this->C_QUERY['strNames']);
		$rule2 = '';
		if (isset($sNames) && mb_strlen($sNames) > 0) {
			$rule1 = ' AND (name LIKE "%' . $sNames . '%" OR second_name LIKE "%' . $sNames . '%"';
		}
		
		$sql = 'SELECT id, login, name, permissionGroup FROM people WHERE permissionGroup!=2 ' . $rule1 . ' ORDER BY name';
		$q = $this->DB->prepare($sql);
		$q->execute();
		if (!$q) return false;
		$j['users'] = array();
		while ($f = $q->fetch(2)) {
			$j['users'][] = array(
				'id' => $f['id'],
				'name' => $f['name'],
				'login' => $f['login'],
				'group' => $f['permissionGroup'],
			);
		}
		return $j;
	}
}
?>