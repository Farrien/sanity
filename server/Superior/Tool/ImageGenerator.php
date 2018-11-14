<?php

namespace Superior\Tool;

use Exception;

class ImageGenerator {
	
	private $res;
	private $results = [
		'originals' => [],
		'thumbs' => []
	];
	
	static private $MIME_Types = array(
		'image/gif'		=> ['imagecreatefromgif',	'imagegif',		'gif'],
		'image/jpg'		=> ['imagecreatefromjpeg',	'imagejpeg',	'jpg'],
		'image/jpeg'	=> ['imagecreatefromjpeg',	'imagejpeg',	'jpg'],
		'image/png'		=> ['imagecreatefrompng',	'imagepng',		'png']
	);
	
	public $lastThumb = NULL;
	
	public function __construct(ImageResource $image) {
		$this->res = $image;
	}
	
	public function createNew() {
		
		return $this;
	}
	
	public function createThumbnail($save_extension = true) {
		/*
		*	$save_extension - doesnt work yet
		*/
		
		$thumb_name = $this->res->name . '_thumbnail';
		
		$im = self::$MIME_Types[$this->res->mimetype][0]($this->res->path);
		
		$thumb_metric = 300;
		$srcWidth = imagesx($im);
		$srcHeight = imagesy($im);
		
		$create = imagecreatetruecolor($thumb_metric, $thumb_metric);
		
		if ($srcWidth > $srcHeight)
			imagecopyresampled($create, $im, 0, 0, round((max($srcWidth, $srcHeight)-min($srcWidth, $srcHeight))/2), 0, $thumb_metric, $thumb_metric, min($srcWidth, $srcHeight), min($srcWidth, $srcHeight));
		
		if ($srcWidth < $srcHeight) 
			imagecopyresampled($create, $im, 0, 0, 0, 0, $thumb_metric, $thumb_metric, min($srcWidth, $srcHeight), min($srcWidth, $srcHeight));
		
		if ($srcWidth == $srcHeight) 
			imagecopyresampled($create, $im, 0, 0, 0, 0, $thumb_metric, $thumb_metric, $srcWidth, $srcWidth);
		
		imagejpeg($create, $this->res->dir . $thumb_name . '.' . self::$MIME_Types[$this->res->mimetype][2], 90);
		imagedestroy($create);
		
		$this->lastThumb = [
			'name' => $thumb_name . '.' . self::$MIME_Types[$this->res->mimetype][2],
			'dir' => $this->res->dir,
			'mimetype' => $this->res->mimetype
		];
		
		return $this;
	}
	
	public function get() {
		return $this->results;
	}
	
	public function getOriginalImageName() {
		return $this->res->name . '.' . self::$MIME_Types[$this->res->mimetype][2];
	}
}