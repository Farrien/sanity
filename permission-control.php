<?
# Stop if this is direct call
defined('SN_Start') or header('Location: //' . $_SERVER['HTTP_HOST'] . '/');

if (is_null($pdo_db)) die(__FILE__ . ' can not run.');
session_start();
global $perm;
if (CheckAccount()) {
	$USER['id'] = $_SESSION['id'];
	$USER['privileges'] = $_SESSION['privileges'];
	$perm = true;
} else {
	if (isset($_POST['sign_in']) && $_POST['sign_in'] == 1) {
		$tryToSign = SignIn();
		if (count($tryToSign) == 0) { # ноль ошибок
			$USER['id'] = $_SESSION['id'];
			$perm = true;
			header('Refresh: 0;URL=');
		}
		$perm = false;
	} else {
		$perm = false;
		if (getCorrectPHPSELF() != 'index.php') {
			header("Location: /home");
			exit();
		}
	}
}
if ($perm == false && getCorrectPHPSELF() != 'index.php') {
	header("Location: /home");
	exit();
}
?>