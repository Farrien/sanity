<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');
defined('OwnOrigin') or RedirectTo('login/?ownp=origin');

$PageTitle = 'Войти';

if (!empty($USER['id']) && isset($USER['privileges'])) {
	$route = array(
		0 => 'private',
		1 => 'panel',
		2 => 'admin',
		3 => 'inspector',
		4 => 'worker'
	);
	$path = 'Location: //' . $_SERVER['HTTP_HOST'] . '/' . $route[$USER['privileges']] . '/';
	RedirectToHome();
}