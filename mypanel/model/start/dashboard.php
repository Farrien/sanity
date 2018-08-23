<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

class StartDashboardModel extends MyPanelModel {
	public function getApps() {
		$q = $this->pdo->query('SELECT IFNULL(app_icon_img, "ui/no-photo-lighter.png") AS app_icon_img, IFNULL(app_tech_path, false) AS fFlag, app_name FROM sanity_prop_apps ORDER BY sort DESC, app_name ASC');
		$apps = [];
		while ($f = $q->fetch(2)) {
			$apps[] = $f;
		}
		return $apps;
	}
}