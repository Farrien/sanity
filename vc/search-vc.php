<?php

//	//	03.09.2018//	Author: Farrien//	

use Superior\Request;
use Superior\Response;

Request::Require('symphony');

Response::Status()->set('301');
Response::Status()->setStatusCode('404');

#return [Response::Status()->getStatusCode()];

if ($request->hasAugments()) {
	$augs = $request->augments();


}

#return [false];