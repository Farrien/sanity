<?php
$SN->helper('Userthings');
$SN->helper('Data');
$SN->helper('Tasks');
$SN->helper('Users');
$SN->helper('Wallet');
$SN->helper('Parser');
$SN->helper('JSON');
$SN->helper('Configurator');

$SN->ext('server/load/component/View');
$SN->ext('server/load/http/Constructor');
$SN->ext('server/load/http/Queries');
$SN->ext('server/load/Permission');
$SN->ext('server/load/Request');
$SN->ext('server/load/Response');
$SN->ext('server/load/Router');

$lang = $SN->ext('support/lang/ru-RU');