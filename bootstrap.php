<?php
$SN->helper('Userthings');
$SN->helper('Data');
$SN->helper('Tasks');
$SN->helper('Users');
$SN->helper('Wallet');
$SN->helper('Parser');
$SN->helper('JSON');
$SN->helper('Configurator');

spl_autoload_register(function($class) {
	$file = $_SERVER['DOCUMENT_ROOT'] . '/server/load/' . $class . '.php';
	if (is_readable($file)) {
		require_once $file;
	}
});

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/load/Permission.php';

$lang = require_once $_SERVER['DOCUMENT_ROOT'] . '/support/lang/ru-RU.php';