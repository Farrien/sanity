<?php
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

namespace Superior\Http;

use Exception;
use Superior\Request;
use SN\Management as SN;

class Constructor {
	public $request;
	public $augments = NULL;
	
	function __construct(Request $object, Array $request_array) {
	#	remove a router's helper
		unset($request_array['p']);
		
		$this->request = (object) $request_array;
	}
	
	public function get() {
		return $this->request;
	}
	
	public function getAugments() {
		if (is_null($this->augments)) {
			try {
				$this->BuildAugmentation();
			} catch (Exception $e) {
				SN::NewErr();
				SN::ExplainLast($e->getMessage());
				$this->augments = false;
				return false;
			}
		}
		return $this->augments;
	}
	
	private function BuildAugmentation() {
		if (isset($_REQUEST['augmentation']) && $_REQUEST['augmentation']!='') {
			$aug = explode('/', trim($_REQUEST['augmentation'], '/'));
			if (count($aug) < 1) {
				throw new Exception('Augmented request is missing. Trying to get properties will provide an error.');
			}
			$this->augments = (object) $aug;
			unset($request_array['augmentation']);
			return;
		}
		throw new Exception('Augmented request is missing. Trying to get properties will provide an error.');
	}
}