<?php

class NewsMainController extends MyPanelController {
	public function start() {
		$this->Model('News/News');
		$this->pageTitle = 'Новости';
		
		$this->Model('News/Base');
		$this->data['news'] = $this->model->get();
		
		$this->output = 'start';
	}
	
	public function add() {
		$this->pageTitle = 'Добавление новости';
		$this->data['input_rows'] = [
			[
				'type' => 'text',
				'name' => 'title',
				'desc' => 'Заголовок'
			],
			[
				'type' => 'textarea',
				'name' => 'content',
				'desc' => 'Содержимое'
			],
			[
				'type' => 'textarea',
				'name' => 'short_desc',
				'desc' => 'Краткое описание'
			],
			[
				'type' => 'number',
				'name' => 'author',
				'desc' => 'Автор'
			],
		
		];
		$this->output = 'add';
	}
	
	public function post() {
		$this->Model('News/Base');
		
		if (empty($this->request['row_title'])) $this->request['row_title'] = '';
		if (empty($this->request['row_content'])) $this->request['row_content'] = '';
		if (empty($this->request['row_short_desc'])) $this->request['row_short_desc'] = '';
		
		if (empty($this->request['row_author']) || $this->request['row_author'] == '') $this->request['row_author'] = NULL;
		
		$this->model->add($this->request['row_title'], $this->request['row_content'], $this->request['row_short_desc'], $this->request['row_author']);
		
		return true;
	}
}