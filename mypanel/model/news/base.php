<?php

class NewsBaseModel extends MyPanelModel {
	public function add($title, $content, $short, $photo = NULL, $author = NULL) {
		$q = $this->pdo->prepare('INSERT INTO `news` (title, content, short_desc, author_id, image_res, added_time) VALUES(?, ?, ?, ?, ?, ?)');
		
		try {
			$this->pdo->beginTransaction();
			$q->execute([
				prepareString($title),
				prepareString($content),
				prepareString($short),
				$author,
				$photo,
				$_SERVER['REQUEST_TIME']
			]);
			$this->pdo->commit();
		} catch (Exception $e) {
			$this->pdo->rollBack();
		}
	}
	
	public function update($id, $title, $content, $short, $photo = NULL, $author = NULL) {
		if (is_null($photo)) {
			$q = $this->pdo->prepare('UPDATE `news` SET title=?, content=?, short_desc=?, author_id=?, updated_time=? WHERE id=?');
			
			try {
				$this->pdo->beginTransaction();
				$q->execute([
					prepareString($title),
					prepareString($content),
					prepareString($short),
					(int) $author,
					$_SERVER['REQUEST_TIME'],
					$id
				]);
				$this->pdo->commit();
			} catch (Exception $e) {
				$this->pdo->rollBack();
			}
		} else {
			$q = $this->pdo->prepare('UPDATE `news` SET title=?, content=?, short_desc=?, author_id=?, updated_time=?, image_res=? WHERE id=?');
			
			try {
				$this->pdo->beginTransaction();
				$q->execute([
					prepareString($title),
					prepareString($content),
					prepareString($short),
					(int) $author,
					$_SERVER['REQUEST_TIME'],
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
			$q = $this->pdo->query('SELECT id, title, added_time FROM `news` ORDER BY id DESC');
			
			while ($f = $q->fetch(2)) {
				$r[] = $f;
			}
			
			return $r;
		} else {
			$q = $this->pdo->prepare('SELECT * FROM `news` WHERE id=?');
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
		$q = $this->pdo->prepare('DELETE FROM `news` WHERE id=?');
		$q->execute([$id]);
	}
}