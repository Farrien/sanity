<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

$PageTitle = 'Главная';

$p = &$USER['privileges'];
if ($p == 0) $linkToCabinet = 'private';
if ($p == 1) $linkToCabinet = 'panel';
if ($p == 2) $linkToCabinet = 'admin';
if ($p == 3) $linkToCabinet = 'inspector';
if ($p == 4) $linkToCabinet = 'worker';
unset($p);

if (empty($USER['id'])) {
	if (empty($_GET['ownp'])) {
		RedirectTo('index/?ownp=origin');
		die('Redirecting...');
	}
	include_once dirname(__DIR__) . '/templates/' . DESIGN_TEMPLATE . '/unauth-index.php';
	die;
} else {
	RedirectTo($linkToCabinet . '/');
	die('Redirecting...');
}