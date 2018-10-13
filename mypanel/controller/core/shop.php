<?php

use Superior\Tool\ImageUpload;

class CoreShopController extends MyPanelController {
	public function save() {
		var_dump($this->request);
		var_dump($_FILES);
		
		$product_id = (int) $this->request['product_id'];
		$articul = (int) $this->request['product_articul'] ?: NULL;
		$name = prepareString($this->request['product_name']) ?: NULL;
		$quantity = (int) $this->request['product_quantity'] ?: 0;
		$cat = (int) $this->request['product_category'] ?: NULL;
		$cost = prepareString($this->request['product_cost']) ?: 0;
		
		ImageUpload::setPath('/res/tests/', true);
		ImageUpload::setSalt(ENC_SALT);
		ImageUpload::upload($_FILES['product_photo'])->createNew()->createThumbnail();
		
		$this->Model('Core/Shop');
		
		if ($product_id) {
			$this->model->edit($product_id, $articul, $name, $quantity, $cat, $cost);
		} else {
			$this->model->add($articul, $name, $quantity, $cat, $cost);
		}
	}
}