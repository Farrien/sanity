<?php
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

#$PageTitle = 'Arthas';

use Helper\Parser;

if ($_SERVER['REQUEST_METHOD'] === 'GET' || true) {
	$requestType = (int) $_REQUEST['request_type'];
	if (empty($requestType) || $requestType == '' || $requestType > 10) return [false];
	
	$backupPath = $_SERVER['DOCUMENT_ROOT'] . '/res/cache/apartments/crm.xml';
	$hasBackup = file_exists($backupPath);
	$backupExpireTime = 3600;
	
	$requireSource = false;
	
	if ($hasBackup) {
		if (($_SERVER['REQUEST_TIME'] - $backupExpireTime) < filemtime($backupPath)) {
			$backup = file_get_contents($backupPath);
			$source = $backup;
			$data[] = $backupExpireTime;
		} else {
			$requireSource = true;
		}
	} else {
		$requireSource = true;
	}
	
	if ($requireSource) {
		$sourceURL = 'http://pb4850.profitbase.ru/export/profitbase_xml/f1f41fb5c65a9d873f7d4c5986f42423';
		$source = Parser::GetSourceFromURL($sourceURL);
		$backupFile = fopen($backupPath, 'w');
		fwrite($backupFile, $source);
		fclose($backupFile);
	}
	
	$xml = simplexml_load_string($source);
	$data = [];
	
	$maxRooms = 3;
	if ($requestType == 1) {
		# apartments sort selection
		$chosenSections = [];
		if ($_REQUEST['param_sections']) $chosenSections = explode(',', $_REQUEST['param_sections']);
		if (is_array($chosenSections) && count($chosenSections) > 0) {
			$chosenSection = [];
			foreach ($chosenSections AS $k=>$v) {
				$chosenSection[$v] = true;
			}
		}
		
		$paramFloorsRange = explode(',', $_REQUEST['param_floors_range'][0]);
		$chosenFloorsMin = (int) $paramFloorsRange[0] ?: 1;
		$chosenFloorsMax = (int) $paramFloorsRange[1] ?: (int) $xml->offer->house->{'floors-total'};
		
		$paramRoomsRange = explode(',', $_REQUEST['param_rooms_range'][0]);
		$chosenRoomsMin = (int) $paramRoomsRange[0] ?: 1;
		$chosenRoomsMax = (int) $paramRoomsRange[1] ?: $maxRooms;
		
		$paramAreaRange = explode(',', $_REQUEST['param_area_range'][0]);
		$chosenAreaMin = (int) $paramAreaRange[0] ?: 25;
		$chosenAreaMax = (int) $paramAreaRange[1] ?: 70;
		
		$paramCostRange = explode(',', $_REQUEST['param_cost_range'][0]);
		$chosenCostMin = (int) $paramCostRange[0] ?: 1000000;
		$chosenCostMax = (int) $paramCostRange[1] ?: 5000000;
		
		foreach ($xml->offer as $offer) {
			$status = (string) $offer->status;
			if ($status == 'SOLD') continue;
			$section = (int) explode(' ', $offer->{'building-section'})[1];
			if ($chosenSection && !$chosenSection[$section]) continue;
			
			$floor = (int) $offer->{'floor'};
			if ($floor < $chosenFloorsMin) continue;
			if ($floor > $chosenFloorsMax) continue;
			
			$rooms = (int) $offer->rooms;
			if ($rooms < $chosenRoomsMin) continue;
			if ($rooms > $chosenRoomsMax) continue;
			
			$area = (string) $offer->area->value;
			if ($area < $chosenAreaMin) continue;
			if ($area > $chosenAreaMax) continue;
			
			$price = (int) $offer->price->value;
			if ($price < $chosenCostMin) continue;
			if ($price > $chosenCostMax) continue;
			
			$data[] = [
				'section' => $section,
				'floor' => $floor,
				'rooms' => $rooms,
				'area' => $area,
				'price' => $price,
				'number' => (int) $offer->number
			];
		}
	}
	/*
	#$data['floors_count'] = (int) $xml->offer->house->{'floors-total'};
	#$data['offers_count'] = count($xml->offer);
	#$data['apartments'] = [];
	foreach ($xml->offer as $offer) {
		$section = (int) explode(' ', $offer->{'building-section'})[1];
	#	$section = $offer->{'building-section'};
		$data['apartments'][$section] = 'wtf';
		$apart_num = (int) $offer->{'number'};
		$data['apartments']['section'.$section][$apart_num] = array(
			'floor' => (int) $offer->{'floor'},
			'rooms' => (int) $offer->rooms,
			'area' => (string) $offer->area->value,
			'price_length' => (int) $offer->{'price-meter'}->value,
			'status' => ((string) $offer->status == 'SOLD') ? 0 : 1,
			'image' => (string) $offer->image,
			'price' => (int) $offer->price->value,
		);
	}*/
	#	$json = $this->FriendlyJson($data);
	return $data;
}
	
	
	
