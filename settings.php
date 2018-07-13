<?
# Stop if this is direct call
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

$ConfigINI = parse_ini_file('app_config.ini');
foreach ($ConfigINI as $k=>$v) {
	define($k, $v);
}