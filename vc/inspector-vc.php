<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

$PageTitle = 'Кабинет ревизора';

# show chat if inspector has any open hookups only
$q = $pdo_db->query('SELECT id FROM hookups_managers WHERE closed=0 AND inspector_id=' . $USER['id']);
$f = $q->fetch(2);
$showChatWindow = $f;
$q = null; $f = null;

$hookup_id = false;
$showChat = false;