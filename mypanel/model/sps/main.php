<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

class SpsMainModel extends MyPanelModel {
	public function allLines() {
		$lines = [];
		$q = $this->pdo->query('SELECT * FROM `#custom_app_bigd_strings`');
		while ($f = $q->fetch(2)) {
			$lines[] = $f;
		}
		return $lines;
	}
}