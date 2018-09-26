<?php

/*
*
*	Прописывать в аргументах
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

$SN = new SN\Management;


$request = new Superior\Request;
$get = $request::Data();

$router = new Superior\Router($request);
$SN->ext('web/routes');

$SN->ext('database');
$SN->ext('util');
$SN->ext('permission-control');

/*
*
*	Необходимо избавиться от этого
*
*/
include 'forso.php';

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
Permission::init($USER['privileges']);
$SN->ext('web/access');

$OwnOrigin = false;
if (isset($_GET['ownp'])) {
	$OwnOrigin = true;
	define('OwnOrigin', true);
}

# Checking VC-part file
$vc_path = CONTROLLER_DIR . $ROUT_P . '-vc.php';
if (file_exists($vc_path)) {
	$vc_result = require_once $vc_path;
}

if (is_array($vc_result)) {
	header('Content-Type: application/json; charset=utf-8');
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
#echo (microtime(true) - $ScriptStartTime);