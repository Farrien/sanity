<?php
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

Abstract class MyPanelModel {
	protected $pdo;
	function __construct() {
		global $pdo_db;
		$this->pdo = $pdo_db;
	}
}