<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

$PageTitle = 'Стать исполнителем';


$apcount = 0;
$q = $pdo_db->query('SELECT id FROM people WHERE permissionGroup=4');
$apcount = $q->rowCount();
$tv1 = '';
if ($apcount == 1) {
	$tv1 = '1 одобренный специалист';
} elseif (1 < $apcount  && $apcount < 5) {
	$tv1 = $apcount . ' одобренных специалиста';
} elseif ($apcount == 0 || $apcount >= 5) {
	$tv1 = $apcount . ' одобренных специалистов';
}
$AcceptedPerformersText = $tv1;

$PerformerFormIsVisible = true;
if ($_COOKIE['b_c_pras']) {
	$PerformerFormIsVisible = false;
}