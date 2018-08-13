<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

class ModulesMainController extends MyPanelController {
	public function start() {
		$this->Model('Modules/Main');
		$this->data['modules_list'] = $this->model->allRegisteredModules();
		$this->SetOutput('public');
		$this->SetTitle('Модули');
	}
	
	public function create() {
		$this->data['wtf'] = 'ash';
	}
	
	public function add() {
		$this->SetOutput('public_create');
		$this->SetTitle('Создание нового модуля');
		
	}
}