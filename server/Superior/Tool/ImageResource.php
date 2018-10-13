<?php

namespace Superior\Tool;

class ImageResource {
	public $path;
	
	public $mimetype;
	
	public function __construct(string $path, string $mimetype) {
		$this->path = $path;
		$this->mimetype = $mimetype;
	}
	
	public function get() {
		return $this->path;
	}
}