<?php

namespace Superior\Tool;

class ImageResource {
	public $path;
	public $dir;
	public $name;
	public $mimetype;
	
	public function __construct(string $path, string $name, string $dir, string $mimetype) {
		$this->path = $path;
		$this->dir = $dir;
		$this->name = $name;
		$this->mimetype = $mimetype;
	}
	
	public function get() {
		return $this->path;
	}
}