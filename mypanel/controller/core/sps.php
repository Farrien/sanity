<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

class CoreSpsController extends MyPanelController {

	public function save() {
		$changed_rows = $this->request['value'];
		if (is_array($changed_rows) && count($changed_rows) > 0) {
			$this->Model('Core/Sps');
			$this->model->save_rows($changed_rows);
		}
		return false;
	}
	
	public function add() {
		$this->Model('Core/Sps');
		$this->model->add_row($this->request['htag'], $this->request['value']);
		return false;
	}
}