<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

class CoreShopModel extends MyPanelModel {
	public function add($articul, $name, $quantity, $cat, $cost) {
		$q = $this->pdo->prepare('INSERT INTO shop_goods (articul, product_name, quantity, category_id, cost, added_time) VALUE (?, ?, ?, ?, ?, ?)');
		$q->execute([$articul, $name, $quantity, $cat, $cost, $_SERVER['REQUEST_TIME']]);
	}
	public function edit($id, $articul, $name, $quantity, $cat, $cost) {
		$q = $this->pdo->prepare('UPDATE shop_goods SET articul=?, product_name=?, quantity=?, category_id=?, cost=?, updated_time=? WHERE id=?');
		$q->execute([$articul, $name, $quantity, $cat, $cost, $_SERVER['REQUEST_TIME'], $id]);
	}
}