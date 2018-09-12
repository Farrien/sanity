<?php
namespace Superior\Component;

class View {
	public $view_component_path;
	public $view_component_variables = [];
	
	public function __construct($path, Array $variables) {
		$this->view_component_variables = $variables;
		$this->view_component_path = $path;
	}
	
	public function vars() {
		return $this->view_component_variables;
	}
	
	public function getPath() {
		return $_SERVER['DOCUMENT_ROOT'] . '/public/' . $this->view_component_path;
	}
	
	
}