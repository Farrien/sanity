<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

class CoreSpsModel extends MyPanelModel {
	public function save_rows(Array $rows) {
		$q = $this->pdo->prepare('UPDATE `#custom_app_bigd_strings` SET string_value=? WHERE id=?');
		try {
			$this->pdo->beginTransaction();
			foreach ($rows AS $k=>$v) {
				$text = prepareString($v);
				$q->execute([$text, $k]);
			}
			$this->pdo->commit();
		} catch (Exception $e) {
			$this->pdo->rollBack();
		}
	}
	
	public function add_row($htag, $text) {
		$htag = strtolower(rus2translit(prepareString($htag)));
		$text = prepareString($text);
		$htag = str_replace(' ', '_', $htag);
		$htag = str_replace('-', '_', $htag);
		
		if (mb_strlen($htag) < 4) {
			return false;
		}
		$q = $this->pdo->prepare('INSERT INTO `#custom_app_bigd_strings` (unique_name, string_value) VALUES(?, ?)');
		$q->execute([$htag, $text]);
	}
}