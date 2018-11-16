<?php

class CommunityMainController extends MyPanelController {
	public function start() {
		$this->Model('Community/Main');
		$this->data['users'] = $this->model->users();
		
		$this->SetTitle('Пользователи');
		$this->SetOutput('page.index');
	}
}