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

use SN\Management as SN;
$SN = new SN;

$request = new Superior\Request;
$get = $request::Data();

/*
$router = new Superior\Router($request);
require_once $_SERVER['DOCUMENT_ROOT'] . '/web/routes.php';
*/

$SN->ext('database');
$SN->ext('util');
$SN->ext('permission-control');

$PageTitle = APP_NAME;

$SN->ext('server/load/MyPanelController');
$SN->ext('server/load/MyPanelModel');



















/*
*
*	Check if a user has permissions to visit a targeted page
*
*/
Permission::init($USER['privileges']);
$SN->ext('web/access');

if (empty($_REQUEST['act'])) $_REQUEST['act'] = 'start/dashboard';

# $RequestOptions ---> $RO
$RO = [];
$RO['ACT'] = trim(prepareString($_REQUEST['act']), '/');
$ACT = explode('/', $RO['ACT']);
$RO['SECTION']	= strtolower($ACT[0]);
$RO['SCRIPT']	= strtolower($ACT[1]);
$RO['ACTION']	= isset($ACT[2]) ? strtolower($ACT[2]) : 'start';
$_REQUEST['AUGMENT'] = isset($ACT[3]) ? strtolower($ACT[3]): NULL;

$ControllerSource = $_SERVER['DOCUMENT_ROOT'] . '/mypanel/controller/' . $RO['SECTION'] . '/' . $RO['SCRIPT'] . '.php';
if (file_exists($ControllerSource)) {
	require_once $ControllerSource;
	$ClassName = $RO['SECTION'] . $RO['SCRIPT'] . 'Controller';
	$METHOD = $RO['ACTION'];
	/*
	$CONTROLLER = new $ClassName($_REQUEST);
	if (is_callable(array($CONTROLLER, $METHOD))) {
		$CONTROLLER->$METHOD($_REQUEST);
		$ConIsPresent = true;
		$useController = true;
	}
	*/
} else {
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: //' . $_SERVER['HTTP_HOST'] . '/mypanel/');
	die;
}

/*
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
*/

use Superior\Response;
if (file_exists($ControllerSource)) {
	$ClassName = $RO['SECTION'] . $RO['SCRIPT'] . 'Controller';
	$controllerInstance = new $ClassName;
	$return = $controllerInstance->$METHOD();
	
	if ($return || is_null($return)) {
		header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
		if ($return instanceof MyPanelController || is_null($return)) {
			header('Content-Type: text/html; charset=utf-8');
			$PageTitle = $controllerInstance->pageTitle;
			$extractedVariablesCount = extract($controllerInstance->data(), EXTR_OVERWRITE);
			include 'body.tpl';
		}
		if (is_array($return)) {
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($return);
		}
		if (is_string($return)) {
			header('Content-Type: text/plain; charset=utf-8');
			echo $return;
		}
	} else {
		header($_SERVER['SERVER_PROTOCOL'] . ' 500');
	}
	
	die;
} else {
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: //' . $_SERVER['HTTP_HOST'] . '/mypanel/');
	
	
	
	
	
	
	
	
	
	
	
	
	
	die;
}