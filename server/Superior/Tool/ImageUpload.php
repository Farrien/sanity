<?php

namespace Superior\Tool;

use Exception;

class ImageUpload {
	
	/*
	*	Path where uploaded image will be placed.
	*/
	static private $Path = '/';
	
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
	
	static public function Generator() {
		
	}
	
	/*
	*	Main method to upload image (securely)
	*
	*	@var	array	$_FILES[?] must be provided; not whole $_FILES
	*	@var	bool	this means should a script save initital image extension or not
	*
	*	@return	array	info about new name of uploaded image, dir where it was uploaded
	*/
	public function upload(array $file, bool $save_extension = true) {
		if (!isset($file['error']) || is_array($file['error'])) {
			throw new Exception('Image uploading provided an error.');
		}
		
		switch ($image['error']) {
			case UPLOAD_ERR_OK : break;

			case UPLOAD_ERR_NO_FILE : throw new Exception('Uploaded image not found.');

			case UPLOAD_ERR_INI_SIZE : 

			case UPLOAD_ERR_FORM_SIZE : throw new Exception('Exceeded size of image.');

			default : throw new Exception('Unknown problem with uploaded image.');
		}
		
		if (!is_array($file) && isset($file['tmp_name'])) {
			throw new Exception('No image with given name uploaded.');
		}
		
		$file_size_min = $this->size_min ?: 512; // 512b
		$file_size_max = $this->size_max ?: 2097152; // 2Mb
		
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
		
		$generated_image = $this->generateImg($file);
		$generated_name = $this->generateName($file);
		
		move_uploaded_file($file['tmp_name'], $this->Path . $generated_name);
		
		$this->lastUploaded = $this->Path . $generated_name;
		
		return [
			'name' => $generated_name,
			'dir' => $this->Path,
			'mimetype' => $this->mime
		];
	}
	
	/*
	*
	*	Use this method after upload method only to be safe
	*
	*/
	public function createThumbnail($save_extension = true) {
		
		$generated_name = $this->generateName($file, 'thumbnail');
		
		$im = self::$MIME_Types[$this->mime][0]($this->lastUploaded);
		
		$thumb_metric = 300; # px
		$srcWidth = imagesx($im);
		$srcHeight = imagesy($im);
		
	#	echo "Исходный размер {$srcWidth}x{$srcHeight}", "\n";
		
		$create = imagecreatetruecolor($thumb_metric, $thumb_metric);
		
		if ($srcWidth > $srcHeight)
			imagecopyresampled($create, $im, 0, 0, round((max($srcWidth, $srcHeight)-min($srcWidth, $srcHeight))/2), 0, $thumb_metric, $thumb_metric, min($srcWidth, $srcHeight), min($srcWidth, $srcHeight));
		
		if ($srcWidth < $srcHeight) 
			imagecopyresampled($create, $im, 0, 0, 0, 0, $thumb_metric, $thumb_metric, min($srcWidth, $srcHeight), min($srcWidth, $srcHeight));
		
		if ($srcWidth == $srcHeight) 
			imagecopyresampled($create, $im, 0, 0, 0, 0, $thumb_metric, $thumb_metric, $srcWidth, $srcWidth);
		
		imagejpeg($create, $this->Path . $generated_name, 90);
	#	imagejpeg($im, $userdataPath.'original/compressed-'.$clearName.'.jpg', 50);
		
		imagedestroy($create);
		# Удаление
	#	unlink ($userdataPath.'original/up'.$clearName.'.jpg');
	
		return new ImageGenerator();
		return [
			'name' => $generated_name,
			'dir' => $this->Path,
			'mimetype' => $this->mime
		];
		
	}
	
	public function generateImg($image) {
		// Extracting mime type using getimagesize
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

		// Calling callback(if set) with path of image as a parameter
		if ($callback !== null) {
			$callback($reprocessed_image);
		}

		$image_to_file($reprocessed_image, $image['tmp_name']);

		// Freeing up memory
		imagedestroy($reprocessed_image);
		
		$this->mime = $mime_type;
	}
	
	public function generateName($image, $any_word = '') {
		$salt = $this->salt ?: 'ImageUploadDefaultSalt';
		
		$name_water = mb_strtolower($image['tmp_name']) . $_SERVER['REQUEST_TIME'] . $salt;
		
		$generated = hash_hmac('md5', $name_water, $salt);
		
		$generated .= '-v' . $_SERVER['REQUEST_TIME'] . '_' . $any_word;
		
		/*
		*	Adding file extension to the generated name
		*/
		$generated .= '.' . self::$MIME_Types[$this->mime][2];
		
		return $generated;
	}
}

/*
*	ImageUpload::Generator()->
*	ImageUpload::upload($_FILES['pic'], true)->createThumbnail();
*/