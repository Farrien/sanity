<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

class CoreModulesController extends MyPanelController {

	public function add() {
		$newModuleName = strtolower(prepareString($this->request['module_name'])) ?: 'undefined_module';
		$newModuleFile = VIEW_DIR . $newModuleName . '.php';

		$vc = $this->request['has_vc'] ?: 0;
		if ($vc) {
			$newModuleVCFile = CONTROLLER_DIR . $newModuleName . '-vc.php';
		}
		$authorName = prepareString($this->request['module_author']) ?: OWNER_NAME;


		if (!file_exists($newModuleFile)) {
			$exampleFile = $_SERVER['DOCUMENT_ROOT'] . '/mypanel/view/core/module_example.tpl';
			$example = file_get_contents($exampleFile, 'r');

			$dateCreated = date('d.m.Y');

			$module = fopen($newModuleFile, 'w');
			fwrite($module, $example);
			fwrite($module, "//	\r//	$dateCreated\r//	Author: $authorName\r//	\r");
			fclose($module);

			if ($vc) {
				$moduleVC = fopen($newModuleVCFile, 'w');
				fwrite($moduleVC, $example);
				fwrite($moduleVC, "//	\r//	$dateCreated\r//	Author: $authorName\r//	\r");
				fclose($moduleVC);
			}

			$this->Model('Core/Modules');
			$this->model->register_new_module($newModuleName, $authorName, $vc);
		}
	//	$this->Relocate('modules/main');
	}
}