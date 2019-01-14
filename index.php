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

require_once 'vendor/autoload.php';
require_once 'bootstrap.php';

use SN\Management as SN;
$SN = new SN;

$request = new Superior\Request;
$get = $request::Data();

/*
$router = new Superior\Router($request);
require_once 'web/routes.php';
*/

$SN->ext('database');
$SN->ext('util');
$SN->ext('permission-control');

$PageTitle = $lang['error'];

use Superior\ControllerHandler as Handler;
Handler::register($request);
$SN->ext('web/handles');

/*
*
*	Simple fake routing
*
*/
if ($_SERVER['REQUEST_URI'] == '/index/' || $_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '//') {
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: /');
	die;
}

if (empty($_REQUEST['p'])) {
	$_REQUEST['p'] = 'index';
}
$ROUT_P = prepareString($_REQUEST['p']);
if (empty($ROUT_P) || !isset($ROUT_P)) $ROUT_P = 'index';
$requestPage = VIEW_DIR . $ROUT_P . '.php';

if (!is_file($requestPage)) {
	SN::NewErr();
	SN::ExplainLast('Page not found.');
}

/*
*
*	Check if a user has permissions to visit a targeted page
*
*/
Permission::init($USER['privileges']);
$SN->ext('web/access');

$OwnOrigin = false;
if (isset($_GET['ownp'])) {
	$OwnOrigin = true;
	define('OwnOrigin', true);
}

/*
*
*	Check if a VC-part file exists
*
*/
$vc_path = CONTROLLER_DIR . $ROUT_P . '-vc.php';
$vc_result = false;
if (file_exists($vc_path)) {
	$vc_result = require_once $vc_path;
}

if (is_array($vc_result)) {
	header('Content-Type: application/json; charset=utf-8');
	if (!$SN->GetErrors()) {
		echo json_encode($vc_result);
		die;
	}
}




















use Superior\Response;
if (Handler::hasController()) {
	$controllerInstance = new Handler::$cm[0];
	$methodName = Handler::$cm[1];
	$return = $controllerInstance->$methodName();
	
	if ($return) {
		header($_SERVER['SERVER_PROTOCOL'] . ' ' . $headerCode);
		if ($return instanceof Superior\Component\View) {
			header('Content-Type: text/html; charset=utf-8');
			$extractedVariablesCount = extract($return->vars(), EXTR_OVERWRITE);
			include $return->getPath();
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
	header('Content-Type: text/html; charset=utf-8');
	if (!$OwnOrigin) include_once TEMPLATES_DIR . DESIGN_TEMPLATE . TPL_PAGE_HEADER;

	if ($SN->GetErrors()) {
		$SN->PrintErrors();
	} else {
		if ($vc_result instanceof Superior\Component\View) {
			$extractedVariablesCount = extract($vc_result->vars(), EXTR_OVERWRITE);
			include_once $vc_result->getPath();
		} else {
			include_once $requestPage;
		}
	}

	if (!$OwnOrigin) include_once TEMPLATES_DIR . DESIGN_TEMPLATE . TPL_PAGE_FOOTER;
	$SN->RegisterScriptDuration();
}