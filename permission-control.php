<?php
session_start();
global $perm;
if (CheckAccount()) {
	$USER['id'] = (int) $_SESSION['id'];
	$USER['privileges'] = (int) $_SESSION['privileges'];
	$perm = true;
} else {
	if (isset($_POST['sign_in']) && $_POST['sign_in'] == 1) {
		$tryToSign = SignIn();
		if (count($tryToSign) == 0) {
			$USER['id'] = $_SESSION['id'];
			$perm = true;
			header('Refresh: 0;URL=');
		}
		$perm = false;
	} else {
		$perm = false;
		if (getCorrectPHPSELF() != 'index.php') {
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: /');
			exit();
		}
	}
}
if ($perm == false && getCorrectPHPSELF() != 'index.php') {
	header('Location: /home');
	exit();
}