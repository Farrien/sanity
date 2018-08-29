<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

setcookie("lgn", "", time() - 360000, '/');
setcookie("pw", "", time() - 360000, '/');

unset($_SESSION);
session_destroy();

RedirectTo('/');