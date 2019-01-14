<?php

use Superior\Tool\ImageUpload;

class HowtobuyMainController extends MyPanelController {
	public function start() {
		$this->pageTitle = 'Раздел как купить';
		
		$this->Model('Howtobuy/Base');
		$this->data['items'] = $this->model->get();
		
		$this->output = 'start';
	}
	
	public function info() {
		$this->pageTitle = 'Информация об ипотеке';
		
		$this->data['input_rows'] = [
			[
				'type' => 'text',
				'name' => 'rate',
				'desc' => 'Ставка',
				'value'=> ''
			],[
				'type' => 'text',
				'name' => 'first_fee',
				'desc' => 'Первый взнос',
				'value'=> ''
			],[
				'type' => 'text',
				'name' => 'age_requirement',
				'desc' => 'Возраст',
				'value'=> ''
			]
		];
		
		$this->data['photo_res'] = '/res/ui/no-photo-big.png';
		
		$this->data['update_state'] = false;
		if (isset($this->request['AUGMENT'])) {
			$aug = (int) $this->request['AUGMENT'];
			if (is_int($aug) && $aug >= 1) {
				$this->Model('Howtobuy/Base');
				$m = $this->model->get($aug);
				if ($m) {
					$this->data['photo_res'] = $m['image_path'] ?: $this->data['photo_res'];
					$this->data['input_rows'][0]['value'] = $m['rate'];
					$this->data['input_rows'][1]['value'] = $m['first_fee'];
					$this->data['input_rows'][2]['value'] = $m['age_requirement'];
					$this->data['update_state'] = true;
					$this->data['id'] = $aug;
				}
			}
		}
		
		$this->output = 'add';
	}
	
	public function post() {
		$threshold = 0;
		
		if (empty($this->request['row_rate'])) {
			$this->request['row_rate'] = 'Не заполнено';
			$threshold++;
		}
		if (empty($this->request['row_first_fee'])) {
			$this->request['row_first_fee'] = 'Не заполнено';
			$threshold++;
		}
		if (empty($this->request['row_age_requirement'])) {
			$this->request['row_age_requirement'] = 'Не заполнено';
			$threshold++;
		}
		
		if ($threshold >= 3) return false;
		
		if (empty($this->request['row_author']) || $this->request['row_author'] == '') $this->request['row_author'] = NULL;
		
		$photo = NULL;
		if ($_FILES['row_photo']['error'] == 0) {
			ImageUpload::setPath('/res/banks/', true);
			ImageUpload::setSalt(ENC_SALT);
			$photo = ImageUpload::upload($_FILES['row_photo'])->getOriginalImageName();
		}
		
		$this->Model('Howtobuy/Base');
		$this->model->add($this->request['row_rate'], $this->request['row_first_fee'], $this->request['row_age_requirement'], '/res/banks/'.$photo);
		
		return true;
	}
	
	public function update() {
		if (isset($this->request['AUGMENT'])) {
			$aug = (int) $this->request['AUGMENT'];
			if (is_int($aug) && $aug >= 1) {
				$target_id = $aug;
			} else {
				return false;
			}
		}
		
		if (empty($this->request['row_rate'])) {
			$this->request['row_rate'] = 'Не заполнено';
			$threshold++;
		}
		if (empty($this->request['row_first_fee'])) {
			$this->request['row_first_fee'] = 'Не заполнено';
			$threshold++;
		}
		if (empty($this->request['row_age_requirement'])) {
			$this->request['row_age_requirement'] = 'Не заполнено';
			$threshold++;
		}
		
		$photo = NULL;
		if ($_FILES['row_photo']['error'] == 0) {
			ImageUpload::setPath('/res/banks/', true);
			ImageUpload::setSalt(ENC_SALT);
			$photo = ImageUpload::upload($_FILES['row_photo'])->getOriginalImageName();
		}

		$this->Model('Howtobuy/Base');
		$this->model->update($target_id, $this->request['row_rate'], $this->request['row_first_fee'], $this->request['row_age_requirement'], '/res/banks/'.$photo);
		
		return true;
	}
	
	public function remove() {
		if (isset($this->request['AUGMENT'])) {
			$aug = (int) $this->request['AUGMENT'];
			if (is_int($aug) && $aug >= 1) {
				$target_id = $aug;
				
				$this->Model('Howtobuy/Base');
				
				if ($this->model->get($target_id)) {
					$this->model->forceDelete($target_id);
					return true;
				}
			}
		}
		
		return false;
	}
}