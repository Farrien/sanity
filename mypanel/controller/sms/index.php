<?
$ScreenTitle = 'Управление SMS';
$uniqueBGStyle = true;

$INI = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/app_config.ini', true);

$SMSReceiver = $INI['SMS_NOTIFICATION_RECEIVER_PHONE'];