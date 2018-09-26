<?php

class CustomRequestsClass Extends BaseController {

	function CallbackRequest() {
		$crProduct = (int) $this->C_QUERY['product_id'];
		$crPhone = prepareString($this->C_QUERY['client_phone']);
		$crPhone = preg_replace('/(\+7|\+8)/', '8', $crPhone, 1);
		if (!preg_match('/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/', $crPhone)) return false;
		
		if (empty($crProduct) || empty($crPhone)) return false;
		
		$q = $this->DB->prepare('INSERT INTO shop_callback_requests (product_id, client_phone, ip_addr, added_time) VALUES (?, ?, ?, ?)');
		$q->execute(array(
			$crProduct,
			$crPhone,
			$_SERVER['REMOTE_ADDR'],
			$_SERVER['REQUEST_TIME']
		));
		return true;
	}
}