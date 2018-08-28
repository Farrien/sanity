<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

class ModulesMainModel extends MyPanelModel {
	public function allRegisteredModules() {
		$modules = [];
		$q = DB::PDO()->query('SELECT link_name FROM sanity_apps_table_modules');
	#	$q = $this->pdo->query('SELECT link_name FROM sanity_apps_table_modules');
		while ($f = $q->fetch(2)) {
			$modules[] = $f;
		}
		return $modules;
	}
}