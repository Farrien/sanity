<?php

abstract class MyPanelController {
	protected $data = [];
	protected $request = [];
	public $pageTitle = 'Default title';
	protected $output = 'index';
	protected $model;
	protected $coreName;
	protected $attachedAugment;
	
	function __construct() {
		$this->request = $_REQUEST;
		unset($this->request['act']);
	}
	
	public function data() {
		return $this->data;
	}
	
	public function view() {
		return $this->output;
	}
	
	protected function Model($model_name) {
		$modelSOURCE = $_SERVER['DOCUMENT_ROOT'] . '/mypanel/model/' . strtolower($model_name) . '.php';
		if (file_exists($modelSOURCE)) {
			$a = explode('/', $model_name);
			require_once $modelSOURCE;
			$m = $a[0] . $a[1] . 'Model';
			$this->model = new $m();
		} else {
			throw new \Exception('Model (in ' . $modelSOURCE . ') not found');
		}
	}
	
	protected function SetTitle($str = 'Missing title') {
		$this->pageTitle = $str;
	}
	
	protected function SetOutput($view_name) {
		$this->output = $view_name;
	}
	
	protected function Relocate($target) {
		header('Location: ../mypanel/?act=' . $target);
	}
	
	public function getTitle() {
		return $this->pageTitle;
	}
}