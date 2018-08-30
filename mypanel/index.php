<?php
const SN_Start = true;

require_once $_SERVER['DOCUMENT_ROOT'] . '/base.php';
use SN\Management;
$SN = new Management;
$SN->helper('Userthings');
$SN->helper('Data');
$SN->helper('Tasks');
$SN->helper('Users');
$SN->helper('Wallet');
$SN->helper('Parser');
$SN->helper('JSON');
$SN->helper('Configurator');

$SN->ext('server/load/controller');
$SN->ext('server/load/model');
$SN->ext('server/load/request');
$SN->ext('server/load/request/constructor');
$SN->ext('server/load/http/queries');
$SN->ext('server/load/response');

$request = new Superior\Request;
$get = $request::Data();

$SN->ext('settings');
$SN->ext('database');
$SN->ext('util');
$SN->ext('permission-control');


$lang = $SN->ext('support/lang/ru-RU');

# Checking access permissions
$SN->ext('server/load/permission');
Permission::init($USER['privileges']);
$SN->ext('web/access');

$ScreenTitle = APP_NAME;

if (empty($_REQUEST['act'])) $_REQUEST['act'] = 'start/dashboard';


# $RequestOptions ---> $RO
$RO = [];
$RO['ACT'] = trim(prepareString($_REQUEST['act']), '/\\');
$a1 = explode('/', $RO['ACT']);
$RO['SECTION'] = ucfirst($a1[0]);
$RO['SCRIPT']= ucfirst($a1[1]);
$RO['ACTION']= $a1[2] ?: 'start';

$conSOURCE_		= __DIR__ . '/controller/' . $RO['SECTION'] . '/' . $RO['SCRIPT'] . '.php';
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
	$PageTitle = $CONTROLLER->getTitle();
} else {
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: //' . $_SERVER['HTTP_HOST'] . '/mypanel/');
	exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if ($useController) {
		include 'body.tpl';
	}
}