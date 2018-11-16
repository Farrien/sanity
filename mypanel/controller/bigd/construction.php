<?php

use Superior\Tool\ImageUpload;

class BigdConstructionController extends MyPanelController {
	public function start() {
		$this->Model('Bigd/Construction');
		$this->data['construction_pics'] = $this->model->getAll();
		
		$this->SetTitle('Ход строительства');
		$this->SetOutput('construction.index');
	}
	
	public function add() {
		$imageUploader = new Superior\Test\ImageUpload();

		$imageUploader->path('/images/construction/');
		$imageUploader->salt = ENC_SALT;
		
		$upload = $imageUploader->upload($_FILES['pic']);
		
		$thumb = $imageUploader->thumb($_FILES['pic']);
		
		$this->Model('Bigd/Construction');
		
		$id = (int) $_REQUEST['item_id'];
		$this->model->updateImage($id, $upload['name'], $thumb['name']);
	}
	
	public function post() {
		$m = $_REQUEST['p_month'] ?: date("n");
		$y = $_REQUEST['p_year'] ?: date("Y");

		ImageUpload::setPath('/images/construction/', true);
		ImageUpload::setSalt(ENC_SALT);
		$Image = ImageUpload::upload($_FILES['p_file']);
		$thumb = $Image->createThumbnail(300, 300)->lastThumb;
		
		$this->Model('Bigd/Construction');
		$this->model->addRow($m, $y, $Image->getOriginalImageName(), $thumb['name']);
		
		return true;
	}
	
	public function remove() {
		if (isset($this->request['AUGMENT'])) {
			$aug = (int) $this->request['AUGMENT'];
			if (is_int($aug) && $aug >= 1) {
				$target_id = $aug;
				
				$this->Model('Bigd/Construction');
				
				$this->model->forceDelete($target_id);
				return true;
			}
		}
		return false;
	}
}