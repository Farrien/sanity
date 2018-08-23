<?
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

require_once './forso.php';

$globalTime = time();
$globalMT = microtime(true);

# Simple fake routing
$PageTitle = 'Главная';
$ROUT_P = prepareString($_REQUEST['p']);
if (empty($ROUT_P) || !isset($ROUT_P)) $ROUT_P = 'index';
$requestPage = VIEW_DIR . $ROUT_P . '.php';

$OwnOrigin = false;
if (isset($_GET['ownp'])) {
	$OwnOrigin = true;
	define('OwnOrigin', true);
}

# Checking VC-part file
$CONTROLLER_FILE_NAME = $ROUT_P . '-vc.php';
$vc_path = CONTROLLER_DIR . $CONTROLLER_FILE_NAME;
if (file_exists($vc_path)) require_once $vc_path;

if ($SN->GetErrors()) $PageTitle = 'Ошибка';
if (!$OwnOrigin) include_once TEMPLATES_DIR . DESIGN_TEMPLATE . TPL_PAGE_HEADER;

if ($SN->GetErrors()) {
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