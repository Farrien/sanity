<?
const SN_Start = true;

require_once $_SERVER['DOCUMENT_ROOT'] . '/base.php';
use SN\Management;
$SN = new Management;

$SN->ext('settings');
$SN->ext('database');
$SN->ext('util');
$SN->ext('permission-control');

$SN->ext('server/load/controller');
$SN->ext('server/load/model');

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
	header('Location: ../mypanel/?act=start/dashboard');
	die();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
<!DOCTYPE html>
<html>
<head>
<?include $_SERVER['DOCUMENT_ROOT'] . '/templates/SanityHeaderLayout.php';?>
</head>
<body <?echo $uniqueBGStyle ? 'class="grey"' : ''?>>
<div class="">
	<div class="uip-WindowSpace">
		<div class="uip-TopPart">
			<div class="uip-ScreenName"><?=$ScreenTitle?></div>
		</div>
		<?if ($useController) {
			$extractedVariablesCount = extract($CONTROLLER->data(), EXTR_OVERWRITE);
			$view = $_SERVER['DOCUMENT_ROOT'] . '/mypanel/view/' . $RO['SECTION'] . '/' . $CONTROLLER->view() . '.php';
			include $view;
		}?>
	</div>
</div>
</body>
</html>
<?}?>