<?php

namespace Superior\Tool;

use Exception;

class ImageUpload {
	
	/*
	*	Path where uploaded image will be placed.
	*/
	static private $Path = '/';
	
	/*
	*	
	*/
	static private $Salt = 'Good Luck';
	
	/*
	*	Helper for re-creating images.
	*/
	static private $Gen = false;
	
	/*
	*	...
	*/
	static public $ClonedImage;
	static public $LastUploaded;
	
	/*
	*	File size conditions
	*/
	static private $Size = ['min' => 512, 'max' => 4194304];
	
	/*
	*	List of valid mime types
	*/
	static private $MIME_Types = array(
		'image/gif'		=> ['imagecreatefromgif',	'imagegif',		'gif'],
		'image/jpg'		=> ['imagecreatefromjpeg',	'imagejpeg',	'jpg'],
		'image/jpeg'	=> ['imagecreatefromjpeg',	'imagejpeg',	'jpg'],
		'image/png'		=> ['imagecreatefrompng',	'imagepng',		'png']
	);
	
	/*
	*	Change directory where images will be uploaded.
	*
	*	@var	string	chosen directory
	*	@var	bool	send TRUE if you need to create a directory dynamically
	*/
	static public function setPath($r, bool $create = false) {
		$p = $_SERVER['DOCUMENT_ROOT'] . $r;
		if (!is_dir($p)) {
			if ($create) {
				mkdir($p, 0777, true);
			} else {
				throw new Exception('Directory not found. If you want to create a directory dynamically, send second argument as TRUE.');
			}
		}
		self::$Path = $p;
	}
	
	static public function setSalt($salt) {
		self::$Salt = $salt;
	}
	
	
	/*
	*	Main method to upload image (securely)
	*
	*	@var	array	$_FILES[?] must be provided; not whole $_FILES
	*	@var	bool	this means should a script save initital image extension or not
	*
	*	@return	array	info about new name of uploaded image, dir where it was uploaded
	*/
	static public function upload(array $file, bool $save_extension = true) {
		$path = self::$Path;
		
		if (!isset($file['error']) || is_array($file['error'])) {
			throw new Exception('Image uploading provided an error.');
		}
		
		switch ($image['error']) {
			case UPLOAD_ERR_OK : break;

			case UPLOAD_ERR_NO_FILE : throw new Exception('Uploaded image not found.');

			case UPLOAD_ERR_INI_SIZE : throw new Exception('Uploaded image is empty.');

			case UPLOAD_ERR_FORM_SIZE : throw new Exception('Exceeded size of image.');

			default : throw new Exception('Unknown problem with uploaded image.');
		}
		
		if (!is_array($file) && isset($file['tmp_name'])) {
			throw new Exception('No image with given name uploaded.');
		}
		
		$file_size_min = self::$Size['min'] ?: 512; // 512b
		$file_size_max = self::$Size['max'] ?: 4194304; // 2Mb
		
		if ($file_size_min > $file_size_max) {
			throw new Exception('Invalid image size parameters.');
		}
		
		if ($file['size'] > $file_size_max) {
			throw new Exception('Image size is too big.');
		}
		
		/*
		*
		*	Checks if first 100 bytes contains any non ASCII char
		*	Throws an exception on any error
		*
		*/
		$contents = file_get_contents($file['tmp_name'], null, null, 0, 100);
		if ($contents === false) {
			throw new Exception('Unable to read uploaded image.');
		}
		$regex = "[\x01-\x08\x0c-\x1f]";
		if (preg_match($regex, $contents)) {
			throw new Exception('Uploaded image is damaged.');
		}
		
		/*
		*	Check image
		*/
		$check = static::checkSource($file);
		
		/*
		*	Adding file extension to the generated name
		*/
		$base_hashed_name = static::generateName($file['tmp_name']);
		$generated_name = $base_hashed_name . '.' . self::$MIME_Types[$check['mime']][2];
		
		
		if (!move_uploaded_file($file['tmp_name'], $path . $generated_name)) {
			throw new Exception('Unable to move uploaded image.');
		}
		
		self::$ClonedImage = $path . $generated_name;
		
		self::$LastUploaded = new ImageResource(self::$ClonedImage, $base_hashed_name, $path, $check['mime']);
		
		return new ImageGenerator(self::$LastUploaded);
	}
	
	/*
	*
	*	Use this method after upload method only to be safe
	*
	*/
	static public function createThumbnail($width, $height, $save_extension = true) {
		$generated_name = static::generateName($file, '_thumbnail');
		
		$im = self::$MIME_Types[self::$LastUploaded->mimetype][0](self::$LastUploaded->path);
		
		$thumb_metric = 150;
		$srcWidth = imagesx($im);
		$srcHeight = imagesy($im);
		
		$create = imagecreatetruecolor($thumb_metric, $thumb_metric);
		
		if ($srcWidth > $srcHeight)
			imagecopyresampled($create, $im, 0, 0, round((max($srcWidth, $srcHeight)-min($srcWidth, $srcHeight))/2), 0, $thumb_metric, $thumb_metric, min($srcWidth, $srcHeight), min($srcWidth, $srcHeight));
		
		if ($srcWidth < $srcHeight) 
			imagecopyresampled($create, $im, 0, 0, 0, 0, $thumb_metric, $thumb_metric, min($srcWidth, $srcHeight), min($srcWidth, $srcHeight));
		
		if ($srcWidth == $srcHeight) 
			imagecopyresampled($create, $im, 0, 0, 0, 0, $thumb_metric, $thumb_metric, $srcWidth, $srcWidth);
		
		imagejpeg($create, self::$Path . $generated_name . '.' . self::$MIME_Types[self::$LastUploaded->mimetype][2], 90);
		imagedestroy($create);
		
		return [
			'name' => $generated_name,
			'dir' => self::$Path,
			'mimetype' => self::$LastUploaded->mimetype
		];
	}
	
	public function checkSource($image) {
		/*
		*	Extracting mime type using getimagesize
		*/
		$image_info = getimagesize($image['tmp_name']);
		if ($image_info === null) {
			throw new Exception('Uploaded image has invalid size.');
		}

		$mime_type = $image_info['mime'];

		if (!array_key_exists($mime_type, self::$MIME_Types)) {
			throw new Exception('Uploaded image has invalid MIME type.');
		}

		$image_from_file = self::$MIME_Types[$mime_type][0];
		$image_to_file = self::$MIME_Types[$mime_type][1];

		$reprocessed_image = $image_from_file($image['tmp_name']);

		if (!$reprocessed_image) {
			throw new Exception('Unable to generate new image from uploaded image.');
		}

		$image_to_file($reprocessed_image, $image['tmp_name']);

		/*
		*	Freeing up memory
		*/
		imagedestroy($reprocessed_image);
		
		return ['mime' => $mime_type];
	}
	
	static public function generateName($base_word, $any_word = '') {
		$salt = self::$Salt ?: 'ImageUploadDefaultSalt';
		
		$name_water = mb_strtolower($base_word) . $_SERVER['REQUEST_TIME'] . $salt;
		
		$generated = hash_hmac('md5', $name_water, $salt);
		
		$generated .= '-v' . $_SERVER['REQUEST_TIME'] . $any_word;
		
		return $generated;
	}
}