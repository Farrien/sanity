<?
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');
//	//	28.08.2018//	Author: The Big D//	
$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
$url = $protocol.$_SERVER['SERVER_NAME'];
$file = json_decode(file_get_contents($url . '/apartments/?request_type=1'), true);

return $file;