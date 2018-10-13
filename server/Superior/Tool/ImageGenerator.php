<?php

namespace Superior\Tool;

use Exception;

class ImageGenerator {
	
	private $res;
	private $results = [
		'originals' => [],
		'thumbs' => []
	];
	
	public function __construct(ImageResource $image) {
		$this->res = $image;
	}
	
	public function createNew() {
		
		return $this;
	}
	
	public function createThumbnail() {
		
		$this->results['thumbs'][] = '';
		return $this;
	}
	
	public function get() {
		return $this->results;
	}
}