<?php

class CommunityMainModel extends MyPanelModel {
	public function users() {
		$q = DB::PDO()->prepare('SELECT id, name, login, (SELECT source FROM sanity_images_keeper WHERE id=image_handle) as photo, added_time FROM people ORDER BY id LIMIT 0,10');
		$q->execute();
		$r = [];
		while ($f = $q->fetch(2)) {
			$f['when_joined'] = time_elapsed('@' . $f['added_time']);
			unset($f['added_time']);
			if (!$f['photo']) $f['photo'] = '/res/ui/auth-page-face-grey.png';
			$r[] = $f;
		}
		
		return $r;
	}
}