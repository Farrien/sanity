<?
use Helper\Userthings as Userthings;
use Helper\Database as Database;
use Helper\Users as Users;

class CustomRequestsClass Extends BaseController {
	
	public function PerformerRequest() {
		$d_phone = prepareString($this->C_QUERY['performerPhone']);
		$d_phone = preg_replace('/(\+7|\+8)/', '8', $d_phone, 1);
		if (!preg_match('/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/', $d_phone)) return false;
		$d_mail = prepareString($this->C_QUERY['performerMail']);
		if ($d_mail == '' || empty($d_mail)) $d_mail = NULL;
		$d_name = prepareString($this->C_QUERY['performerName']);
		$d_secondname = prepareString($this->C_QUERY['performerSecondName']);
		$d_msg = prepareString($this->C_QUERY['performerMsg']);
		
		if (empty($d_phone) || empty($d_name) || empty($d_secondname) || empty($d_msg)) return false;
		
		
		$sql = 'INSERT INTO `#custom_table_performers_requests` (performer_phone, performer_name, performer_secondname, performer_mail, request_message, added_time) VALUES (?, ?, ?, ?, ?, ?)';
		$q = $this->DB->prepare($sql);
		$q->execute(array(
			$d_phone,
			$d_name,
			$d_secondname,
			$d_mail,
			$d_msg,
			$_SERVER['REQUEST_TIME']
		));
		setcookie('b_c_pras', true, $_SERVER['REQUEST_TIME'] + 36000, '/performer-verification/');
		return true;
	}
	
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