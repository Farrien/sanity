<?
# Stop if this is direct call
defined('SN_Start') or header('Location: //' . $_SERVER['HTTP_HOST'] . '/');

try {
	$pdo_db = new PDO('mysql:host='.DATABASE_SETTING_HOSTNAME.';dbname='.DATABASE_SETTING_DBNAME.';charset=utf8;', DATABASE_SETTING_USER, DATABASE_SETTING_PASSWORD);
} catch (PDOException $e) {
	die('4** Problems with connections. Try again later.');
}
?>