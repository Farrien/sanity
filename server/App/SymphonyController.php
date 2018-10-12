<?php

namespace App;

use Superior\Response;
use Superior\Tool\ImageUpload;

class SymphonyController extends Controller {
	public function index() {
		$ImageUpload = new ImageUpload();
		ImageUpload::path('/res/uploads/');
		return 'Hello String';
		return ['Hello' => 'String'];
		return Response::View('symphony.php');
	}
}