<?php

spl_autoload_register(function($class) {
	$file = $_SERVER['DOCUMENT_ROOT'] . '/server/' . $class . '.php';
	if (is_readable($file)) {
		require_once $file;
	}
});

use Helper\Configurator;
Configurator::initConfig('app_config.ini');

define('TEMPLATES_DIR', $_SERVER['DOCUMENT_ROOT'] . '/templates/');
define('CONTROLLER_DIR', $_SERVER['DOCUMENT_ROOT'] . '/vc/');
define('VIEW_DIR', $_SERVER['DOCUMENT_ROOT'] . '/public/');

require_once $_SERVER['DOCUMENT_ROOT'] . '/server/load/Permission.php';

$lang = require_once $_SERVER['DOCUMENT_ROOT'] . '/support/lang/' . SITE_LANG . '-' . mb_strtoupper(SITE_LANG) . '.php';