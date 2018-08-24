<?php
if ($_GET['show_errors']) {
	ini_set('display_errors', '1');
	error_reporting(E_ALL);
}
$ScriptStartTime = microtime(true);
const SN_Start = true;
$perm = false;

require_once $_SERVER['DOCUMENT_ROOT'] . '/base.php';

use SN\Management;
$SN = new Management;

$SN->ext('settings');
$SN->ext('database');
$SN->ext('util');
$SN->ext('permission-control');
/*
$SN->helper('Userthings');
$SN->helper('Data');
$SN->helper('Tasks');
$SN->helper('Users');
$SN->helper('Wallet');
*/
$lang = $SN->ext('support/lang/ru-RU');

require_once './forso.php';

$globalTime = time();
$globalMT = microtime(true);

# Simple fake routing
if (empty($_REQUEST['p'])) {
	$_REQUEST['p'] = 'index';
}
$ROUT_P = prepareString($_REQUEST['p']);
if (empty($ROUT_P) || !isset($ROUT_P)) $ROUT_P = 'index';
$requestPage = VIEW_DIR . $ROUT_P . '.php';

# Checking access permissions
#$SN->ext('server/load/permission');
#Permission::init($USER['privileges']);
#$SN->ext('web/access');

$OwnOrigin = false;
if (isset($_GET['ownp'])) {
	$OwnOrigin = true;
	define('OwnOrigin', true);
}

# Checking VC-part file
$CONTROLLER_FILE_NAME = $ROUT_P . '-vc.php';
$vc_path = CONTROLLER_DIR . $CONTROLLER_FILE_NAME;
if (file_exists($vc_path)) {
	$vc_result = require_once $vc_path;
}


if (is_array($vc_result)) {
	header('Content-Type: application/json; charset=utf-8');
	
	echo json_encode($vc_result);
	exit;
} else {
	header('Content-Type: text/html; charset=utf-8');

	if (!$OwnOrigin) include_once TEMPLATES_DIR . DESIGN_TEMPLATE . TPL_PAGE_HEADER;

	if ($SN->GetErrors()) {
		$PageTitle = $lang['error'];
		$SN->PrintErrors();
	} else {
		if (is_file($requestPage)) {
			require_once $requestPage;
		} else {
			include VIEW_DIR . 'standard/404.php';
		}
	}

	if (!$OwnOrigin) include_once TEMPLATES_DIR . DESIGN_TEMPLATE . TPL_PAGE_FOOTER;

	$SN->RegisterScriptDuration();
}
#echo (microtime(true) - $ScriptStartTime);