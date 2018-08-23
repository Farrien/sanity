<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

class StartDashboardController extends MyPanelController {
	public function start() {
		$this->SetTitle('Главная');
		$this->Model('Start/Dashboard');
		$this->data['apps'] = $this->model->getApps();
	}
}

/*
$conf = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/app_config.ini', true);

$newINI = makeINI($conf);
$configFile = fopen('sconfig.ini', 'w');
fwrite($configFile, $newINI); 
fclose($configFile);*/