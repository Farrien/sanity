<?php

abstract class MyPanelController {
	protected $data = [];
	protected $request = [];
	public $pageTitle = 'Default title';
	protected $output = 'index';
	protected $model;
	
	function __construct($req) {
		$this->request = $req;
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