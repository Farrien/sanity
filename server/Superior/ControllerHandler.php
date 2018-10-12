<?php

namespace Superior;

class ControllerHandler {
	
	static private $requestPage = 'index';
	static private $has = false;
	static public $cm = [];
	
	static public function register(Request &$request) {
		static::$requestPage = $request->getCurrentPage();
	}
	
	/*
	*	@param	string
	*	@param	string
	*	@param	string
	*
	*	@return void
	*/
	static public function bind($pageName, $controllerName = NULL, $method = 'index') : void {
		if (static::$has) return;
		$pageName = strtolower($pageName);
		if (is_null($controllerName)) {
			$controllerName = ucwords($pageName) . 'Controller';
		}
		$app = 'App\\' . $controllerName;
		if ($pageName === static::$requestPage && class_exists($app)) {
			if (is_callable([$app, $method])) {
				static::$has = true;
				static::$cm = [$app, $method];
			}
		}
	}
	
	/*
	*	Check if a controller exists
	*
	*	@return bool
	*/
	static public function hasController() : bool {
		return static::$has;
	}
}