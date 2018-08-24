<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

class SpsMainController extends MyPanelController {
	public function start() {
		$this->Model('Sps/Main');
		$this->data['lines'] = $this->model->allLines();
	#	$this->SetOutput('public');
		$this->SetTitle('Строки и тексты');
	}
}