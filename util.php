<?php
# Stop if this is direct call
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

function getCorrectPHPSELF () {
	preg_match('/([-\w]+).php/', $_SERVER['PHP_SELF'], $match);
	return $match[0];
}

function CheckAccount() {
	global $pdo_db;
	if (isset($_SESSION['id'])) {
		# SESSION существует
		#echo "Сессия найдена \n";
		if (isset($_COOKIE['lgn']) && isset($_COOKIE['pw'])) {
		#	echo "Куки найдены \n";
			setcookie('lgn', $_COOKIE['lgn'], $_SERVER['REQUEST_TIME'] + 172800, '/');
			setcookie('pw', $_COOKIE['pw'], $_SERVER['REQUEST_TIME'] + 172800, '/');
			
		#	echo "Куки обновлены \n";
			return true;
		} else {
			#echo "Куки не найдены \n";
			$newQ = "SELECT login, pass FROM people WHERE id=? LIMIT 1";
			$q1 = $pdo_db->prepare($newQ);
			$q1->execute(array($_SESSION['id']));
			$response = $q1->fetch(PDO::FETCH_ASSOC);
			
			setcookie('lgn', $response['login'], $_SERVER['REQUEST_TIME'] + 172800, '/');
			setcookie('pw', $response['pass'], $_SERVER['REQUEST_TIME'] + 172800, '/');
			
			#echo "Куки выставлены \n";
			return true;
		}
	} else {
		# SESSION нет
		#echo "Сессии нет \n";
		if (isset($_COOKIE['lgn']) && isset($_COOKIE['pw'])) {
			#echo "Куки найдены \n";
			$newQ = "SELECT id, login, pass, permissionGroup FROM people WHERE login=?";
			$newP = array($_COOKIE['lgn']);
			$mA = $pdo_db->prepare($newQ);
			$mA->execute($newP);
			$matches = $mA->fetchColumn();
			$response = $mA->fetch(PDO::FETCH_ASSOC);
			
			if ($matches == 1 && $response['pass'] == $_COOKIE['pw']) {
				$_SESSION['id'] = $response['id'];
				$_SESSION['privileges'] = $response['permissionGroup'];
				return true;
			} else {
				setcookie('lgn', '', $_SERVER['REQUEST_TIME'] - 360000, '/');
				setcookie('pw', '', $_SERVER['REQUEST_TIME'] - 360000, '/');
				return false;
			}
		} else {
			return false;
		}
	}
	return false;
}

function SignIn() {
	$err = array();
	if ($_REQUEST['my_login'] != '' && $_REQUEST['my_password'] != '') {
		$lgn = $_REQUEST['my_login'];
		$pw = hash_hmac('md5', $_REQUEST['my_password'], 'SweetHarmony');
		
		global $pdo_db;
		$sql = 'SELECT COUNT(*) FROM people WHERE login=?';
		$pars = array($lgn);
		$q = $pdo_db->prepare($sql);
		$q->execute($pars);
		$matches = $q->fetchColumn();
		if ($matches == 1) {
			$sql = 'SELECT id, login, pass, permissionGroup FROM people WHERE login=?';
			$q = $pdo_db->prepare($sql);
			$q->execute($pars);
			$response = $q->fetch(2);
			if (strcmp($lgn, $response['login']) == 0) {
				
			} else {
				# Не подходит логин по регистру
				$err[]='Неверный логин и/или пароль.';
				return $err;
			}
			if ($pw == $response['pass']) {
				$_SESSION['id'] = $response['id'];
				$_SESSION['privileges'] = $response['permissionGroup'];
				return $err;
			} else {
				# Не тот пароль
				$err[]='Неверный логин и/или пароль.';
				return $err;
			}
		} else {
			# Не существует логина
			$err[]='Неверный логин и/или пароль.';
			return $err;
		}
	} else {
		$err[]='Логин и/или пароль не введены';
		return $err;
	}
}

function CheckUser(&$U, &$perm) {
	if (CheckAccount()) {
		#echo 'Account Checked';
		$U = $_SESSION['id'];
		$perm = true;
	} else {
		#echo 'Account unchecked';
		if (isset($_REQUEST['sign_in']) && $_REQUEST['sign_in'] == 1) {
			$tryToSign = SignIn();
			if (count($tryToSign) == 0) { # ноль ошибок
				$U = $_SESSION['id'];
				$perm = true;
				header('Refresh: 0;URL=');
			}
			$perm = false;
		} else {
			$perm = false;
			if (getCorrectPHPSELF() != 'index.php') {
				header("Location: //");
			//	exit();
			}
		}
	}
	if ($perm == false && getCorrectPHPSELF() != 'index.php') {
		header("Location: //");
	//	exit();
	}
}


function cyrJson($str) {
/*	THIS CAN NO LONGER WORK IN PHP <7.0
	=====
	$str = preg_replace_callback('/\\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
	return iconv('cp1251', 'utf-8', $str);
	=====
	New version : Used anonymous function instead 
	Fixed at 18.02.2018 */
	$str = preg_replace_callback(
		'/\\\\u([a-f0-9]{4})/i',
		function($m) { 
			return chr(hexdec($m[1])-1072+224);
		},
		$str
	);
	return iconv('cp1251', 'utf-8', $str);
}

function GetTranslatedString($str, $add) {
	if ($str == 'month-short') {
		$a = array(
			'Янв',
			'Фев',
			'Март',
			'Апр',
			'Май ',
			'Июн',
			'Июл',
			'Авг',
			'Сен',
			'Окт',
			'Нбр',
			'Дек',
		);
		return ($a[intval($add)-1]);
	}
}

function normalizeCost($i = '000') {
	$i = round($i/100).'.'.substr($i, -2);
	return $i;
}

function prepareString($str, $ignore_tags = true) {
	$str = trim($str);
	if (!$ignore_tags) return htmlspecialchars(strip_tags($str));
	return htmlspecialchars($str);
}

function prettyTime($i, $type = 'd.m.y') {
	$i = round($i);
	if (!empty($_COOKIE['clientTimezone'])) {
		$i = $i - $_COOKIE['clientTimezone'];
	}
	date_default_timezone_set('Asia/Yekaterinburg');
	$r = date($type, $i);
	return $r;
}

function RedirectToHome() {
	die('<script type="text/javascript">window.location = "http://' . $_SERVER['HTTP_HOST'] . '/";</script>Redirecting...');
}

function RedirectTo($page) {
	if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||  isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
		$protocol = 'https://';
	} else {
		$protocol = 'http://';
	}
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: ' . $protocol . $_SERVER['HTTP_HOST'] . $page);
	exit;
}

function makeShort($str, $l = 100) {
	if (mb_strlen($str) <= $l) return $str;
	/*
	$chr = ' ';
	$str = mb_substr($str, 0, mb_stripos($str, $chr, $l));
	$str = trim($str, "!,.-");
	return $str . '...';
	*/
	$str = strip_tags($str);
	$str = substr($str, 0, $l);
	$str = substr($str, 0, strrpos($str, ' '));
	$str = rtrim($str, "!,.-");
	$str .= '...';
	return $str;

}

// FROM https://stackoverflow.com/questions/1416697/converting-timestamp-to-time-ago-in-php-e-g-1-day-ago-2-days-ago
function time_elapsed($time, $full = false) {
	date_default_timezone_set('UTC');
	$now = new DateTime;
	$ago = new DateTime($time);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => ' год',
		'm' => ' месяц',
		'w' => ' недел',
		'd' => ' дн',
		'h' => ' час',
		'i' => ' минут',
		's' => ' секунд',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$d = $diff->$k;
			if ($k == 's' || $k == 'i') {
				if ($d == 1): $v = $v . 'у';
				elseif ($d > 1 && $d < 5): $v = $d . $v . 'ы';
				else : $v = $d . $v;
				endif;
			} elseif ($k == 'h') {
				if ($d == 1): $v = $v;
				elseif ($d > 1 && $d < 5): $v = $d . $v . 'а';
				else : $v = $d . $v . 'ов';
				endif;
			} elseif ($k == 'd') {
				if ($d == 1): $v = ' день';
				elseif ($d > 1 && $d < 5): $v = $d . $v . 'я';
				else : $v = $d . $v . 'ей';
				endif;
			} elseif ($k == 'w') {
				if ($d == 1): $v = ' неделю';
				elseif ($d > 1 && $d < 5): $v = $d . $v . 'и';
				else : $v = $d . $v . 'ь';
				endif;
			} elseif ($k == 'm') {
				if ($d == 1): $v = $v;
				elseif ($d > 1 && $d < 5): $v = $d . $v . 'а';
				else : $v = $d . $v . 'ев';
				endif;
			} elseif ($k == 'y') {
				if ($d == 1): $v = $v;
				elseif ($d > 1 && $d < 5): $v = $d . $v . 'а';
				else : $v = $d . ' лет';
				endif;
			} else {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			}
		} else {
			unset($string[$k]);
		}
	}

	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' назад' : 'только что';
}

function makeINI(array $a, array $parent = array()) {
	$out = '';
	foreach ($a as $k => $v) {
		if (is_array($v)){
			//subsection case
			//merge all the sections into one array...
			$sec = array_merge((array) $parent, (array) $k);
			//add section information to the output
			$out .= '[' . join('.', $sec) . ']' . PHP_EOL;
			//recursively traverse deeper
			$out .= makeINI($v, $sec);
		} else {
			//plain key->value case
			$out .= "$k=$v" . PHP_EOL;
		}
	}
	return $out;
}

function rus2translit($string) {
	$converter = array(
		'а' => 'a',   'б' => 'b',   'в' => 'v',
		'г' => 'g',   'д' => 'd',   'е' => 'e',
		'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
		'и' => 'i',   'й' => 'y',   'к' => 'k',
		'л' => 'l',   'м' => 'm',   'н' => 'n',
		'о' => 'o',   'п' => 'p',   'р' => 'r',
		'с' => 's',   'т' => 't',   'у' => 'u',
		'ф' => 'f',   'х' => 'h',   'ц' => 'c',
		'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
		'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
		'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
		
		'А' => 'A',   'Б' => 'B',   'В' => 'V',
		'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
		'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
		'И' => 'I',   'Й' => 'Y',   'К' => 'K',
		'Л' => 'L',   'М' => 'M',   'Н' => 'N',
		'О' => 'O',   'П' => 'P',   'Р' => 'R',
		'С' => 'S',   'Т' => 'T',   'У' => 'U',
		'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
		'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
		'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
		'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
	);
	return strtr($string, $converter);
}