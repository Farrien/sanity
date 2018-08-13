<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

class CoreModulesModel extends MyPanelModel {
	public function register_new_module($name, $author, $vc_flag) {
		$q = $this->pdo->prepare('INSERT INTO sanity_apps_table_modules (link_name, module_author, require_vc) VALUE (?, ?, ?)');
		$q->execute([$name, $author, $vc_flag]);
	}
}