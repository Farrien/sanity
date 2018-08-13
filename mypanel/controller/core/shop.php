<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

class CoreShopController extends MyPanelController {
	public function save() {
		var_dump($this->request);
		
		$product_id = (int) $this->request['product_id'];
		$articul = (int) $this->request['product_articul'] ?: NULL;
		$name = prepareString($this->request['product_name']) ?: NULL;
		$quantity = (int) $this->request['product_quantity'] ?: 0;
		$cat = (int) $this->request['product_category'] ?: NULL;
		$cost = prepareString($this->request['product_cost']) ?: 0;
		
		$this->Model('Core/Shop');
		
		if ($product_id) {
			$this->model->edit($product_id, $articul, $name, $quantity, $cat, $cost);
		} else {
			$this->model->add($articul, $name, $quantity, $cat, $cost);
		}
	}
}