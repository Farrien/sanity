<?php
/*
*
*	Вывод ошибок
*
*/
if (isset($_GET['show_errors']) && $_GET['show_errors']==1) {
	ini_set('display_startup_errors', '1');
	ini_set('display_errors', '1');
	error_reporting(E_ALL);
}

define('SN_Start', microtime(true));
$perm = false;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

$SN = new SN\Management;

$request = new Superior\Request;
$get = $request::Data();

/*
$router = new Superior\Router($request);
require_once $_SERVER['DOCUMENT_ROOT'] . '/web/routes.php';
*/

$SN->ext('database');
$SN->ext('util');
$SN->ext('permission-control');

$ScreenTitle = APP_NAME;

# Checking access permissions
Permission::init($USER['privileges']);
$SN->ext('web/access');

if (empty($_REQUEST['act'])) $_REQUEST['act'] = 'start/dashboard';

# $RequestOptions ---> $RO
$RO = [];
$RO['ACT'] = trim(prepareString($_REQUEST['act']), '/');
$a1 = explode('/', $RO['ACT']);
$RO['SECTION'] = strtolower($a1[0]);
$RO['SCRIPT']= strtolower($a1[1]);
$RO['ACTION']= $a1[2] ?: 'start';

$SN->ext('server/load/MyPanelController');
$SN->ext('server/load/MyPanelModel');
$conSOURCE_ = $_SERVER['DOCUMENT_ROOT'] . '/mypanel/controller/' . $RO['SECTION'] . '/' . $RO['SCRIPT'] . '.php';
if (file_exists($conSOURCE_)) {
	require_once $conSOURCE_;
	$classname = $RO['SECTION'] . $RO['SCRIPT'] . 'Controller';
	$METHOD = $RO['ACTION'];
	$CONTROLLER = new $classname($_REQUEST, $pdo_db);
	if (is_callable(array($CONTROLLER, $METHOD))) {
		$CONTROLLER->$METHOD($_REQUEST);
		$ConIsPresent = true;
		$useController = true;
	}
#	$PageTitle = $CONTROLLER->getTitle();
	$PageTitle = $CONTROLLER->pageTitle;
} else {
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: //' . $_SERVER['HTTP_HOST'] . '/mypanel/');
	exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	header('HTTP/1.1 200 OK');
	header('Content-Type: text/html');
	header('Access-Control-Allow-Origin: Origin');
	header('Access-Control-Allow-Credentials: true');
	header('Cache-Control: no-cache, no-store, no-transform');
	header('Access-Control-Max-Age: 10');
	header('Access-Control-Allow-Methods: POST, GET');
	header('Access-Control-Allow-Headers: Origin');
	if ($useController) {
		include 'body.tpl';
	}
}