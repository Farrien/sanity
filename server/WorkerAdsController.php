<?php
use Helper\Userthings as Userthings;
use Helper\Database as Database;

class WorkerAdsClass Extends BaseController {

	public function NewAd() {
		if (empty($this->C_QUERY['ad_msg']) || empty($this->C_QUERY['ad_sub'])) return false;
		$o1 = $this->DB->prepare("INSERT INTO workers_ads (worker_id, worker_ad_desc, worker_cost, worker_ad_subject, added_time) VALUES(?, ?, ?, ?, ?)");
		if (empty($this->C_QUERY['ad_cost']) || $this->C_QUERY['ad_cost'] == '') $this->C_QUERY['ad_cost'] = 0;
		$o1->execute(array(
			$this->CurrentUserID,
			prepareString($this->C_QUERY['ad_msg']),
			abs(intval($this->C_QUERY['ad_cost'])),
			intval($this->C_QUERY['ad_sub']),
			$_SERVER['REQUEST_TIME']
		));
		return true;
	}

}