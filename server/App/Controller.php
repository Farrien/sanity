<?php

namespace App;

abstract class Controller implements Basics {
	
	public function bind($k, $v) {
		$this->{$k} = $v;
	}
}