<?php
namespace Superior;

class Router {
	private $waretype = 'vc';
	private $handler =  '';
	private $param = '';
	private $patterns = [
		'num'		=> '[0-9]+',
		'string'	=> '[a-zA-Z\.\-_%]+',
		'all'		=> '[a-zA-Z0-9\.\-_%]+',
	];
	private $requestPage = 'index';
	
	function __construct(Request &$request) {
		$this->requestPage = $request->getCurrentPage();
	}
	
	public function route($url, $ware, $request_method = 'GET') {
		if ($this->checkDependencyURL($url)) {
			$this->setWare($ware);
		}
	}
	
	private function checkDependencyURL($url) {
		$page = explode('/', $url)[0];
		if ($this->requestPage == $page) return true;
		return false;
	}
	
	private function setWare($ware) {
		$f1 = explode('?', $ware);
		$this->waretype = $f1[0];
		if ($f1[0] === 'controller') {
			$f2 = explode('/', $f1[1]);
			$this->handler = $f2[0];
			$this->param = $f2[1];
		}
		$this->handler = $f1[1];
	}
	
	public function execute() {
		return $this;
	}
	
	public function case() {}
	
	public function getResourcePath() {
		
	}
}