<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

class ShopProductsController extends MyPanelController {
	public function start() {
		$this->Model('Shop/Products');
		$this->data['products'] = $this->model->getProducts();
		
		$this->SetTitle('Товары');
		$this->SetOutput('index');
	}
	
	public function form() {
		$this->Model('Shop/Products');
		
		$product_id = (int) $this->request['product_id'];
		$product = $this->model->getProduct($product_id);
		$this->data['id'] = $product['id'] ?: 0;
		$this->data['articul'] = $product['articul'];
		$this->data['name'] = $product['product_name'];
		$this->data['quantity'] = $product['quantity'];
		$this->data['category'] = $product['category_id'];
		$this->data['cost'] = $product['cost'];
		$this->data['source_photo'] = $product['cover_image'];
		
		$this->SetTitle('Создание/изменение товара');
		$this->SetOutput('product_form');
	}
	
}