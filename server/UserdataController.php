<?php
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

use Helper\Userthings;
use Helper\Users;

class UserdataClass Extends BaseController {

	public function AcceptUser($arg1) {
		$j1 = array();
		$j1['comments'] = 'emptyFields';
		if (empty($_FILES['regPhoto']) || empty($this->C_QUERY['regLogin']) || empty($this->C_QUERY['regPassword']) || empty($this->C_QUERY['regName']) || empty($this->C_QUERY['regSName']) || empty($this->C_QUERY['regGroup']) || empty($this->C_QUERY['regYE']) || empty($this->C_QUERY['regYF'])) return $j1;
		if (true) {
			
			$img = $_FILES['regPhoto'];
			
			$j1['comments'] = 'noPic';
			if ($img['error'] == 4) return $j1;
			
			# Проверяем размер файла и если он превышает заданный размер
			# завершаем выполнение скрипта и выводим ошибку
			if ($img['size'] > 10485760) { # 10Mb
				exit('error file size');
			}
		#	echo 'Размер фото '.round($img['size'] / 1024 / 1024, 2).'Mb ('.filesize($img['tmp_name']).' bytes)', "\n";
			$imgFormat = explode('.', $img['name']);
			$imgFormat = $imgFormat[1];
			
			$j1['comments'] = 'wrongType';
			if ($img['type'] == 'image/jpeg' || $img['type'] == 'image/png') {
				$userdataPath = './res/userdata/';
				$dynamicValue = time();
				$clearName = hash('crc32', $dynamicValue.'-photo');
				$fileNewName = 'up'.$clearName.'.'.$imgFormat;
				$tempFile = $img['tmp_name'];
				
			#	echo 'Новое имя файла '.$fileNewName, "\n";
				
				move_uploaded_file($tempFile, $userdataPath.'original/'.$fileNewName);
			
				if(preg_match('/[.](PNG)|(png)$/', $imgFormat)) {
					$im = imagecreatefrompng($userdataPath.'original/'.$fileNewName);
				}
				if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $imgFormat)) {
					$im = imagecreatefromjpeg($userdataPath.'original/'.$fileNewName);
				}
				
				$mS = 320; # px
				$srcWidth = imagesx($im);
				$srcHeight = imagesy($im);
				
			#	echo "Исходный размер {$srcWidth}x{$srcHeight}", "\n";
				
				$create = imagecreatetruecolor($mS, $mS);
				
				if ($srcWidth > $srcHeight)
					imagecopyresampled($create, $im, 0, 0, round((max($srcWidth, $srcHeight)-min($srcWidth, $srcHeight))/2), 0, $mS, $mS, min($srcWidth, $srcHeight), min($srcWidth, $srcHeight));
				
				if ($srcWidth < $srcHeight) 
					imagecopyresampled($create, $im, 0, 0, 0, 0, $mS, $mS, min($srcWidth, $srcHeight), min($srcWidth, $srcHeight));
				
				if ($srcWidth == $srcHeight) 
					imagecopyresampled($create, $im, 0, 0, 0, 0, $mS, $mS, $srcWidth, $srcWidth);
				
				imagejpeg($create, $userdataPath.'up'.$clearName.'.jpg');
				imagejpeg($im, $userdataPath.'original/compressed-'.$clearName.'.jpg', 50);
				
				# Удаление
				unlink ($userdataPath.'original/up'.$clearName.'.jpg');
				
				# Если есть данные POST, то заносим все в таблицу, включая ссылку на фото. Иначе это просто загрузка фото.
			
				$sql = "INSERT INTO `people` (`login`, `pass`, `name`, `second_name`, `studyGroup`, `yearEnter`, `yearFinal`, `avatar`, `added_time`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$args = array(
					$this->C_QUERY['regLogin'],
					hash_hmac('md5', $this->C_QUERY['regPassword'], 'SweetHarmony'),
					$this->C_QUERY['regName'],
					$this->C_QUERY['regSName'],
					strtoupper ($this->C_QUERY['regGroup']),
					intval($this->C_QUERY['regYE']),
					intval($this->C_QUERY['regYF']),
					'up'.$clearName.'.jpg',
					time()
				);
				$o1 = $this->DB->prepare($sql);
				$o1->execute($args);
				
				$j1['comments'] = 'successful';
				return $j1;
			}
			return $j1;
		}
		return false;
	}
	
	public function Signup() {
		if (empty($this->C_QUERY['regLogin']) || $this->C_QUERY['sign_up'] != 1 || empty($this->C_QUERY['regName'])) return false;
		$c = Userthings::AddNewUser($this->C_QUERY['regLogin'], NULL, $this->C_QUERY['regName']);
		if ($c) return true;
		return false;
	}
	
	public function Signin() {
		if (empty($this->C_QUERY['authLogin']) || $this->C_QUERY['sign_in'] != 1 || empty($this->C_QUERY['authPass'])) return false;
		$login = prepareString($this->C_QUERY['authLogin']);
		$login = preg_replace('/(\+7|\+8)/', '8', $login, 1);
		if (!preg_match('/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/', $login)) return false;
		
		if (Userthings::CheckLoginExisting($login)) {
			$id = Userthings::GetIdentifierByLogin($login);
			$relatedPass = hash_hmac('md5', prepareString($this->C_QUERY['authPass']), 'SweetHarmony');
			if ($relatedPass === Userthings::GetPasswordByID($id)) {
				session_start();
				$_SESSION['id'] = $id;
				$_SESSION['privileges'] = Users::getAccessLvl($id);
				setcookie("lgn", $login, $_SERVER['REQUEST_TIME'] + 172800, '/');
				setcookie("pw", $relatedPass, $_SERVER['REQUEST_TIME'] + 172800, '/');
				return true;
			}
		}
		return false;
	}
	
	public function Restore() {
		if (empty($this->C_QUERY['authLogin'])) return false;
		$login = prepareString($this->C_QUERY['authLogin']);
		$login = preg_replace('/(\+7|\+8)/', '8', $login, 1);
		if (!preg_match('/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/', $login)) return false;
		if (!Userthings::CheckLoginExisting($login)) return false;
		
		$password = NULL;
		// Password generation
	//	$chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
		$chars = "0123456789";
		$max = 6;
		$size = strLen($chars) - 1;
		while($max--) $password .= $chars[rand(0,$size)];
		$hpass = hash_hmac('md5', $password, 'SweetHarmony');
		// Sending SMS with password to user
		include_once dirname(__DIR__) . '/outsource/smsc_api.php';
		send_sms($login, 'Ваш новый пароль для UfaEyes: ' . $password . '. Вы воспользовались формой восстановления пароля.', 0, 0, 0, 0, 'UfaEyes');
		
		$id = Userthings::GetIdentifierByLogin($login);
		$this->setPassword($hpass, $id);
		return true;
	}
	
	public function ChangePassword() {
		if (empty($this->C_QUERY['oldpass']) || empty($this->C_QUERY['wishpass']) || empty($this->C_QUERY['wishpasscheck'])) return false;
	//	$j1['q'] = $this->C_QUERY;
		$relatedPass = hash_hmac('md5', prepareString($this->C_QUERY['oldpass']), 'SweetHarmony');
		if ($relatedPass === Userthings::GetPasswordByID($this->CurrentUserID)) {
			if ($this->C_QUERY['wishpass'] !== $this->C_QUERY['wishpasscheck']) return false;
			$newPass = prepareString($this->C_QUERY['wishpass'], false);
			$j1['prep'] = $newPass;
			if (mb_strlen($newPass) < 1) return false;
			$newPass = hash_hmac('md5', $newPass, 'SweetHarmony');
			$this->setPassword($newPass, $this->CurrentUserID);
			$j1['comments'] = 'password changed';
			return $j1;
		}
		return false;
	}
	
	private function setPassword($new, $id) {
		$sql = 'UPDATE people SET pass=?, pass_updated_time=? WHERE id=?';
		$q = $this->DB->prepare($sql);
		$q->execute(array($new, $_SERVER['REQUEST_TIME'], $id));
	}
}
?>