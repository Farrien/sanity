<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

class ShopProductsModel extends MyPanelModel {
	public function getProducts() {
		$q = $this->pdo->prepare('SELECT id, articul, product_name, quantity, cost FROM shop_goods ORDER BY articul');
		$q->execute([$name, $author, $vc_flag]);
		$r = [];
		while ($f = $q->fetch(2)) {
			$r[] = $f;
		}
		return $r;
	}
	
	public function getProduct($id) {
		$q = $this->pdo->prepare('SELECT id, articul, product_name, category_id, quantity, cost FROM shop_goods WHERE id=?');
		$q->execute([$id]);
		$r = [];
		$f = $q->fetch(2);
		return $f;
	}
}