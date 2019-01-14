<?php

use Superior\Tool\MediaUpload;

class DocsMainController extends MyPanelController {
	public function start() {
		$this->pageTitle = 'Документы';
		
		$this->Model('Docs/Base');
		$this->data['docs'] = $this->model->get();
		$this->output = 'start';
	}
	
	public function doc() {
		$this->pageTitle = 'Документы';
		
		$this->data['input_rows'] = [
			[
				'type' => 'text',
				'name' => 'name',
				'desc' => 'Название',
				'value'=> ''
			]
		];
		
		$this->data['file_name'] = 'Файл не выбран';
		
		$this->data['update_state'] = false;
		if (isset($this->request['AUGMENT'])) {
			$aug = (int) $this->request['AUGMENT'];
			if (is_int($aug) && $aug >= 1) {
				$this->Model('Docs/Base');
				$m = $this->model->get($aug);
				if ($m) {
					$this->data['file_name'] = $m['path'] ? $m['path'] : 'Файл не выбран';
					$this->data['input_rows'][0]['value'] = $m['doc_name'];
					$this->data['update_state'] = true;
					$this->data['docs_id'] = $aug;
				}
			}
		}
		
		$this->output = 'add';
	}
	
	public function post() {
		if (empty($this->request['row_name']) || $this->request['row_name'] == '') $this->request['row_name'] = NULL;
		
		if (count($_FILES) != 1 && empty($_FILES['row_file'])) {
			return false;
		}
		
		$docx_mime = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
		$loaded_mime = $_FILES['row_file']['type'];
		
		$syncs = [
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => '.docx',
			'application/pdf' => '.pdf'
		];
		
		if ($loaded_mime == 'application/pdf' || $loaded_mime == $docx_mime) {
			$generated = mb_strtolower(prepareString(basename($_FILES['row_file']['name'], $syncs[$loaded_mime]))) . $_SERVER['REQUEST_TIME'];
			$generated = hash_hmac('md5', $generated, ENC_SALT);
			$new_name = 'doc_' . $generated . $syncs[$loaded_mime];
			
			echo $new_name;
			
			$path = $_SERVER['DOCUMENT_ROOT'] . '/res/docs/pdf/';
			if (!is_dir($path)) {
				mkdir($path, 0777, true);
			}
			
			move_uploaded_file($_FILES['row_file']['tmp_name'], $path . $new_name);
			
			
			$this->Model('Docs/Base');
			$this->model->add($this->request['row_name'], '/res/docs/pdf/' . $new_name);
			
			return true;
		}
		
		return false;
	}
	
	public function remove() {
		if (isset($this->request['AUGMENT'])) {
			$aug = (int) $this->request['AUGMENT'];
			if (is_int($aug) && $aug >= 1) {
				
				$this->Model('Docs/Base');
				
				if ($this->model->get($aug)) {
					$this->model->forceDelete($aug);
					return true;
				}
			}
		}
		
		return false;
	}
}