<?php

use Superior\Tool\ImageUpload;

class NewsMainController extends MyPanelController {
	public function start() {
		$this->pageTitle = 'Новости';
		
		$this->Model('News/Base');
		$this->data['news'] = $this->model->get();
		
		$this->output = 'start';
	}
	
	public function info() {
		$this->pageTitle = 'Добавление новости';
		
		global $USER;
		$this->data['input_rows'] = [
			[
				'type' => 'text',
				'name' => 'title',
				'desc' => 'Заголовок',
				'value'=> ''
			],[
				'type' => 'textarea',
				'name' => 'content',
				'desc' => 'Содержимое',
				'value'=> ''
			],[
				'type' => 'textarea',
				'name' => 'short_desc',
				'desc' => 'Краткое описание',
				'value'=> ''
			],[
				'type' => 'number',
				'name' => 'author',
				'desc' => 'Автор',
				'value'=> $USER['id']
			]
		];
		
		$this->data['photo_res'] = '/res/ui/no-photo-big.png';
		
		$this->data['update_state'] = false;
		if (isset($this->request['AUGMENT'])) {
			$aug = (int) $this->request['AUGMENT'];
			if (is_int($aug) && $aug >= 1) {
				$this->Model('News/Base');
				$m = $this->model->get($aug);
				if ($m) {
					$this->data['photo_res'] = $m['image_res'] ? '/images/news/' . $m['image_res'] : '/res/ui/no-photo-big.png';
					$this->data['input_rows'][0]['value'] = $m['title'];
					$this->data['input_rows'][1]['value'] = $m['content'];
					$this->data['input_rows'][2]['value'] = $m['short_desc'];
					$this->data['input_rows'][3]['value'] = $m['author_id'];
					$this->data['update_state'] = true;
					$this->data['news_id'] = $aug;
				}
			}
		}
		
		$this->output = 'add';
	}
	
	public function post() {
		$threshold = 0;
		
		if (empty($this->request['row_title'])) {
			$this->request['row_title'] = '';
			$threshold++;
		}
		if (empty($this->request['row_content'])) {
			$this->request['row_content'] = '';
			$threshold++;
		}
		if (empty($this->request['row_short_desc'])) {
			$this->request['row_short_desc'] = '';
			$threshold++;
		}
		
		if ($threshold >= 3) return false;
		
		if (empty($this->request['row_author']) || $this->request['row_author'] == '') $this->request['row_author'] = NULL;
		
		$photo = NULL;
		if ($_FILES['row_photo']['error'] == 0) {
			ImageUpload::setPath('/images/news/', true);
			ImageUpload::setSalt(ENC_SALT);
			$photo = ImageUpload::upload($_FILES['row_photo'])->getOriginalImageName();
		}
		
		$this->Model('News/Base');
		$this->model->add($this->request['row_title'], $this->request['row_content'], $this->request['row_short_desc'], $photo, $this->request['row_author']);
		
		return true;
	}
	
	public function update() {
		if (isset($this->request['AUGMENT'])) {
			$aug = (int) $this->request['AUGMENT'];
			if (is_int($aug) && $aug >= 1) {
				$target_id = $aug;
			}
		}
		
		$this->Model('News/Base');
		
		if (empty($this->request['row_title'])) $this->request['row_title'] = '';
		if (empty($this->request['row_content'])) $this->request['row_content'] = '';
		if (empty($this->request['row_short_desc'])) $this->request['row_short_desc'] = '';
		
		if (empty($this->request['row_author'])) $this->request['row_author'] = NULL;
		
		$photo = NULL;
		if ($_FILES['row_photo']['error'] == 0) {
			ImageUpload::setPath('/images/news/', true);
			ImageUpload::setSalt(ENC_SALT);
			$photo = ImageUpload::upload($_FILES['row_photo'])->getOriginalImageName();
		}

		$this->model->update($target_id, $this->request['row_title'], $this->request['row_content'], $this->request['row_short_desc'], $photo, $this->request['row_author']);
		
		return true;
	}
	
	public function remove() {
		if (isset($this->request['AUGMENT'])) {
			$aug = (int) $this->request['AUGMENT'];
			if (is_int($aug) && $aug >= 1) {
				$target_id = $aug;
				
				$this->Model('News/Base');
				
				if ($this->model->get($target_id)) {
					$this->model->forceDelete($target_id);
					return true;
				}
			}
		}
		
		return false;
	}
}