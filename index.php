<?php
header('HTTP/1.1 200 OK');
header('Content-Type: text/html');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Cache-Control: no-cache, no-store, no-transform');
header('Access-Control-Max-Age: 10');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Origin, X-Requested-With');
if ($_GET['show_errors']) {
	ini_set('display_errors', '1');
	error_reporting(E_ALL);
}
$ScriptStartTime = microtime(true);
const SN_Start = true;
$perm = false;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/base.php';

$SN = new SN\Management;

require_once $_SERVER['DOCUMENT_ROOT'] . '/general_classes.php';

$request = new Superior\Request;
$get = $request::Data();

$router = new Superior\Router($request);
$SN->ext('web/routes');

$SN->ext('settings');
$SN->ext('database');
$SN->ext('util');
$SN->ext('permission-control');

require_once './forso.php';

$globalTime = time();
$globalMT = microtime(true);

$PageTitle = $lang['error'];

# Simple fake routing
if (empty($_REQUEST['p'])) {
	$_REQUEST['p'] = 'index';
}
$ROUT_P = prepareString($_REQUEST['p']);
if (empty($ROUT_P) || !isset($ROUT_P)) $ROUT_P = 'index';
$requestPage = VIEW_DIR . $ROUT_P . '.php';

if (!is_file($requestPage)) {
	$SN->AddErr();
	$SN->ExplainLastError('Page not found.');
}

# Checking access permissions
$SN->ext('server/load/permission');
$SN->ext('web/access');

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
	header('Content-Type: application/json');
	if (!$SN->GetErrors()) {
		echo json_encode($vc_result);
		exit;
	}
}
if (true) {
	header('Content-Type: text/html; charset=utf-8');
	if (!$OwnOrigin) include_once TEMPLATES_DIR . DESIGN_TEMPLATE . TPL_PAGE_HEADER;

	if ($SN->GetErrors()) {
		$SN->PrintErrors();
	} else {
		include_once $requestPage;
	}

	if (!$OwnOrigin) include_once TEMPLATES_DIR . DESIGN_TEMPLATE . TPL_PAGE_FOOTER;
	$SN->RegisterScriptDuration();
}
#echo (microtime(true) - $ScriptStartTime);