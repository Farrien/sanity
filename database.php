<?
# Stop if this is direct call
defined('SN_Start') or header('Location: //' . $_SERVER['HTTP_HOST'] . '/');

define('HOST', 'localhost');
define('DBNAME', 'printer-shop');
define('ROOT', 'root');
define('HOST_PASS', '');

try {
	$pdo_db = new PDO('mysql:host='.HOST.';dbname='.DBNAME.';charset=utf8;', ROOT, HOST_PASS);
} catch (PDOException $e) {
	die('4** Problems with connections. Try again later.');
}
?>