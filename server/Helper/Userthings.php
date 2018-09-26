<?php
namespace Helper;

class Userthings {
	
	static public function AddNewUser($login, $pass, $name, $second_name = '') {
		global $pdo_db;
		
		$login = prepareString($login);
		$login = preg_replace('/(\+7|\+8)/', '8', $login, 1);
		$name = mb_strtoupper(mb_substr($name, 0, 1)).mb_substr(mb_strtolower($name), 1);
		
		if (!preg_match('/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/', $login)) return false;
		if (self::CheckLoginExisting($login)) return false;
		$password = NULL;
		if ($pass == '' || $pass == NULL) {
			// Password generation
		//	$chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
			$chars = "0123456789";
			$max = 6;
			$size = strLen($chars) - 1;
			while($max--) $password .= $chars[rand(0,$size)];
		} else {
			$password = prepareString($pass);
		}
		$hpass = hash_hmac('md5', $password, 'SweetHarmony');
		
		// Sending SMS with password to user
		
		include_once dirname(__DIR__) . '/outsource/smsc_api.php';
		send_sms($login, "Ваш пароль для UfaEyes: $password. Вы можете его изменить в Настройках.", 0, 0, 0, 0, 'UfaEyes');
		
		$sql = "INSERT INTO `people` (`login`, `pass`, `name`, `second_name`, `added_time`) VALUES (?, ?, ?, ?, ?)";
		$args = array(
			$login,
			$hpass,
			prepareString($name),
			prepareString($second_name),
			$_SERVER['REQUEST_TIME'],
		);
		$o1 = $pdo_db->prepare($sql);
		$o1->execute($args);
		$lastRowID = $pdo_db->lastInsertId();
		return array('id'=>$lastRowID, 'password'=>$hpass);
	}
	
	static public function CheckLoginExisting($login) {
		global $pdo_db;
		$login = prepareString($login);
		$login = preg_replace('/(\+7|\+8)/', '8', $login, 1);
		$sql = "SELECT COUNT(login) FROM people WHERE login=?";
		$o1 = $pdo_db->prepare($sql);
		$o1->execute(array($login));
		$f1 = $o1->fetchColumn();
		if ($f1 > 0) {
			return true;
		}
		return false;
	}
	
	static public function GetIdentifierByLogin($login) {
		global $pdo_db;
		$sql = "SELECT id FROM people WHERE login=?";
		$o1 = $pdo_db->prepare($sql);
		$o1->execute(array($login));
		$f1 = $o1->fetch();
		return $f1['id'];
	}
	
	static public function GetPasswordByID($ID) {
		global $pdo_db;
		$sql = "SELECT pass FROM people WHERE id=?";
		$o1 = $pdo_db->prepare($sql);
		$o1->execute(array($ID));
		$f1 = $o1->fetch(2);
		return $f1['pass'];
	}
	
	static public function GetPasswordChangeTime($ID) {
		global $pdo_db;
		$sql = "SELECT pass_updated_time FROM people WHERE id=?";
		$o1 = $pdo_db->prepare($sql);
		$o1->execute(array($ID));
		$f1 = $o1->fetch(2);
		return $f1['pass_updated_time'];
	}
}
?>