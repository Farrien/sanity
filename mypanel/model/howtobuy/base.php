<?php

class HowtobuyBaseModel extends MyPanelModel {
	public function add($rate, $fee, $age, $image = NULL) {
		$q = $this->pdo->prepare('INSERT INTO `custom_app_bigd_htb` (rate, first_fee, age_requirement, image_path) VALUES(?, ?, ?, ?)');
		
		try {
			$this->pdo->beginTransaction();
			$q->execute([
				prepareString($rate),
				prepareString($fee),
				prepareString($age),
				$image
			]);
			$this->pdo->commit();
		} catch (Exception $e) {
			$this->pdo->rollBack();
		}
	}
	
	public function update($id, $rate, $fee, $age, $photo = NULL) {
		if (is_null($photo)) {
			$q = $this->pdo->prepare('UPDATE `custom_app_bigd_htb` SET rate=?, first_fee=?, age_requirement=? WHERE id=?');
			
			try {
				$this->pdo->beginTransaction();
				$q->execute([
					prepareString($rate),
					prepareString($fee),
					prepareString($age),
					$id
				]);
				$this->pdo->commit();
			} catch (Exception $e) {
				$this->pdo->rollBack();
			}
		} else {
			$q = $this->pdo->prepare('UPDATE `custom_app_bigd_htb` SET rate=?, first_fee=?, age_requirement=?, image_path=? WHERE id=?');
			
			try {
				$this->pdo->beginTransaction();
				$q->execute([
					prepareString($rate),
					prepareString($fee),
					prepareString($age),
					$photo,
					$id
				]);
				$this->pdo->commit();
			} catch (Exception $e) {
				$this->pdo->rollBack();
			}
		}
	}
	
	public function get($id = NULL) {
		if (is_null($id)) {
			$r = [];
			$q = $this->pdo->query('SELECT id, image_path FROM `custom_app_bigd_htb` ORDER BY id DESC');
			
			while ($f = $q->fetch(2)) {
				$r[] = $f;
			}
			
			return $r;
		} else {
			$q = $this->pdo->prepare('SELECT * FROM `custom_app_bigd_htb` WHERE id=?');
			$q->execute([$id]);
			$f = $q->fetch(2);
			if ($f) {
				return $f;
			} else {
				return false;
			}
		}
	}
	
	public function forceDelete($id) {
		$q = $this->pdo->prepare('DELETE FROM `custom_app_bigd_htb` WHERE id=?');
		$q->execute([$id]);
	}
}