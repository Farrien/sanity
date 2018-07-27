<?
#error_reporting(E_ALL);
#ini_set('display_errors', 1);

$ScriptStartTime = microtime(true);
const SN_Start = true;
$perm = false;

require_once './base.php';
$SN = new SN_Management;

$SN->ext('settings');
$SN->ext('database');
$SN->ext('util');
$SN->ext('permission-control');

$SN->helper('Userthings');
$SN->helper('Data');
$SN->helper('Tasks');
$SN->helper('Users');
$SN->helper('Wallet');

include_once './forso.php';

$globalTime = time();
$globalMT = microtime(true);

# Simple routing
$PageTitle = 'Главная';
if (!empty($_REQUEST['p']) && (isset($_REQUEST['p']) || isset($_REQUEST['page']))) {
	$requestPage = './public/' . $_REQUEST['p'] . '.php';
	if (isset($PageNames[$_REQUEST['p']])) {
		$PageTitle = $PageNames[$_REQUEST['p']]; # also used as title of page
	}
} else {
	$requestPage = './public/index.php';
	$_REQUEST['p'] = 'index';
}

$OwnOrigin = false;
if (isset($_GET['ownp'])) {
	$OwnOrigin = true;
	define('OwnOrigin', true);
}

# Checking VC-part file
$vc_path = './vc/' . $_REQUEST['p'] . '-vc.php';
$vc = file_exists($vc_path);

if ($vc) require_once $vc_path;

if (!$OwnOrigin) include_once './templates/' . DESIGN_TEMPLATE . '/' . TPL_PAGE_HEADER;

if (!$SN->GetErrors()) {
	if (is_file($requestPage)) {
		include $requestPage;
	} else {
		include './public/standard/404.php';
	}
} else {
	echo '<div style="font-size: 150%;"><strong>Недопустимая ошибка:</strong></div>';
	$SN->PrintErrors();
}

if (!$OwnOrigin) include_once './templates/' . DESIGN_TEMPLATE . '/' . TPL_PAGE_FOOTER;

$SN->RegisterScriptDuration();
?>