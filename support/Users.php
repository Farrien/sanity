<?
namespace Helper\Users;

class Users {
	private static $db;
	private static $prep;
	private static $Table = array();
	
	public function __construct() {
		global $pdo_db;
		self::$db = $pdo_db;
		$sql = 'SELECT login, name, permissionGroup, added_time FROM people WHERE id=?';
		self::$prep = $pdo_db->prepare($sql);
	}
	
	static private function prepare($id) {
		if (empty(self::$Table[$id]) || is_null(self::$Table[$id])) {
			self::$prep->execute(array($id));
			self::$Table[$id] = self::$prep->fetch(2);
		}
	}
	
	static public function getLogin($id) {
		if (is_null(self::$db)) new self();
		self::prepare($id);
		return self::$Table[$id]['login'];
	}
	
	static public function getName($id) {
		if (is_null(self::$db)) new self();
		self::prepare($id);
		return self::$Table[$id]['name'];
	}
	
	static public function getAccessLvl($id) {
		if (is_null(self::$db)) new self();
		self::prepare($id);
		return self::$Table[$id]['permissionGroup'];
	}
	
	static public function getPrivateSettings($id) {
		if (is_null(self::$db)) new self();
		self::prepare($id);
		
		$suffix = hash_hmac('md5', self::getLogin($id) . self::$Table[$id]['added_time'], 'SweetHarmony');
		$file_full_name = 'sn_options_user' . $suffix;
		if (file_exists('./user_section/' . $file_full_name)) {
			$result = json_decode(file_get_contents('./user_section/' . $file_full_name), true);
			return $result;
		}
		return false;
	}
}