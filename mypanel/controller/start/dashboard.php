<?
$q = $pdo_db->query('SELECT IFNULL(app_icon_img, "ui/no-photo-lighter.png") AS app_icon_img, IFNULL(app_tech_path, false) AS fFlag, app_name FROM sanity_prop_apps ORDER BY sort DESC, app_name ASC');
$AllApps = [];
while ($f = $q->fetch(2)) {
	$AllApps[] = $f;
}

/*
$conf = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/app_config.ini', true);

$newINI = makeINI($conf);
$configFile = fopen('sconfig.ini', 'w');
fwrite($configFile, $newINI); 
fclose($configFile);*/