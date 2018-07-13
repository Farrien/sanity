<?
error_reporting(E_ALL);
ini_set('display_errors', 1);
const SN_Start = true;


require_once $_SERVER['DOCUMENT_ROOT'] . '/base.php';
$SN = new SN_Management;

$SN->ext('settings');
$SN->ext('database');
$SN->ext('util');

$ScreenTitle = APP_NAME;

if (empty($_REQUEST['act'])) $_REQUEST['act'] = 'start/hello';

# $RequestOptions ---> $RO
$RO = [];
$RO['ACT'] = $_REQUEST['act'];
$RO['ACT'] = trim($RO['ACT'], '/\\');
$a1 = explode('/', $RO['ACT']);
$RO['SECTION'] = $a1[0];
$RO['SCRIPT']= $a1[1];


$ViewIsPresent	= false;
$ConIsPresent	= false;
$viewSOURCE		= __DIR__ . '/view/' . $RO['SECTION'] . '/' . $RO['SCRIPT'] . '.php';
$conSOURCE		= __DIR__ . '/controller/' . $RO['SECTION'] . '/' . $RO['SCRIPT'] . '.php';
if (file_exists($viewSOURCE)) {
	$ViewIsPresent = true;
	if (file_exists($conSOURCE)) {
		require_once $conSOURCE;
		$ConIsPresent = true;
	}
}
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
		<?if ($ViewIsPresent) include $viewSOURCE?>
	</div>
</div>
</body>
</html>