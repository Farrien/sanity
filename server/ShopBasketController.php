<?php

class ShopBasketClass Extends BaseController {
	public function ConvertProducts() {
		$items = json_decode($this->C_QUERY['items']);
		$list = [];
		if (count($items) > 0) {
			foreach ($items AS $v) {
				$v = (int) $v;
				if (!$list[$v]) $list[$v] = 0;
				$list[$v]++;
			}
			
			$_postWhere = '';
			$flag = count($list);
			foreach ($list AS $k=>$v) {
				$_postWhere .= 'id=' . $k;
				if (--$flag) $_postWhere .= ' OR ';
			}
			
			$result = [];
			$q = $this->DB->prepare('SELECT id, product_name, cost FROM shop_goods WHERE ' . $_postWhere . ' ORDER BY product_name');
			$q->execute([]);
			while ($f = $q->fetch(2)) {
				$f['count'] = $list[$f['id']];
				$f['total_cost'] = $f['count'] * $f['cost'];
				$result[] = $f;
			}
			
			return $result;
		}
		return false;
	}
	
	public function performNewOrder() {
		$items = json_decode($this->C_QUERY['items']);
		$list = [];
		if (count($items) > 0) {
			foreach ($items AS $v) {
				$v = (int) $v;
				if (!$list[$v]) $list[$v] = 0;
				$list[$v]++;
			}
			
			$_postWhere = '';
			$flag = count($list);
			foreach ($list AS $k=>$v) {
				$_postWhere .= 'id=' . $k;
				if (--$flag) $_postWhere .= ' OR ';
			}
			
			/*
			*	Creating new unquie order
			*/
			$q = $this->DB->prepare('INSERT INTO shop_orders (client_id, client_phone, added_time) VALUES (?, ?, ?)');
		//	return $q;
			$q->execute([$this->CurrentUserID, NULL, $_SERVER['REQUEST_TIME']]);
			$order_id = $this->DB->lastInsertId();
			return $order_id;
			
			foreach ($list AS $k=>$v) {
				$q1 = $this->DB->prepare('INSERT INTO shop_order_product_dependency (product_id, order_id, count) VALUES (?, ?, ?)');
				$q1->execute([$k, $order_id, $v]);
				$q1 = NULL;
			}
			
			return true;
		}
		return false;
	}
}