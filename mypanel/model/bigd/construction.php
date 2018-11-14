<?php

class BigdConstructionModel extends MyPanelModel {
	public function getAll() {
		$q = $this->pdo->prepare('SELECT * FROM custom_app_bigd_construction_progress ORDER BY year DESC, month');
		$q->execute([$name, $author, $vc_flag]);
		$r = [];
		while ($f = $q->fetch(2)) {
			$r[] = $f;
		}
		return $r;
	}
	
	public function updateImage($id, $path, $thumbnail) {
		$q = $this->pdo->prepare('UPDATE custom_app_bigd_construction_progress SET photo_path=?, thumbnail_path=? WHERE id=?');
		$q->execute([$path, $thumbnail, $id]);
	}
	
	public function addRow($month, $year, $image, $thumb) {
		$q = $this->pdo->prepare('INSERT INTO `custom_app_bigd_construction_progress` (photo_path, thumbnail_path, year, month) VALUE (?, ?, ?, ?)');
		$q->execute([$image, $thumb, $year, $month]);
	}
	
	public function forceDelete($id) {
		$q = $this->pdo->prepare('DELETE FROM `custom_app_bigd_construction_progress` WHERE id=?');
		$q->execute([$id]);
	}
}