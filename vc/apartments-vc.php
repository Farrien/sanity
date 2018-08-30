<?php
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

use Helper\Parser;

if (true) {
	$requestType = (int) $_REQUEST['request_type'];
	if (empty($requestType) || $requestType == '' || $requestType > 10) return [];
	
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
		Parser::SaveContent($source, $backupPath);
	}
	
	$xml = simplexml_load_string($source);
	$data = [];
	
	$maxRooms = 3;
	if ($requestType == 1) {
		# apartments sort selection
		$chosenSections = [];
		
	/*	if ($_REQUEST['param_sections']) $chosenSections = $_REQUEST['param_sections'];
		if (is_array($chosenSections) && count($chosenSections) > 0) {
			$chosenSection = [];
			foreach ($chosenSections AS $k=>$v) {
				$chosenSection[$v] = true;
			}
		}*/
		if ($_REQUEST['param_sections']) $chosenSection = (int) $_REQUEST['param_sections'];
		
		
	#	$paramFloorsRange = explode(',', $_REQUEST['param_floors_range']);
		$paramFloorsRange = $_REQUEST['param_floors_range'];
	#	var_dump($paramFloorsRange);
		$chosenFloorsMin = (int) $paramFloorsRange[0] ?: 1;
		$chosenFloorsMax = (int) $paramFloorsRange[1] ?: (int) $xml->offer->house->{'floors-total'};
		
	#	echo 'Мин этаж ' . $chosenFloorsMin;
	#	echo 'Макс этаж ' . $chosenFloorsMax;
		
	#	$paramRoomsRange = explode(',', $_REQUEST['param_rooms_range']);
		$paramRoomsRange = $_REQUEST['param_rooms_range'];
		$chosenRoomsMin = (int) $paramRoomsRange[0] ?: 1;
		$chosenRoomsMax = (int) $paramRoomsRange[1] ?: $maxRooms;
		
	#	$paramAreaRange = explode(',', $_REQUEST['param_area_range']);
		$paramAreaRange = $_REQUEST['param_area_range'];
		$chosenAreaMin = (int) $paramAreaRange[0] ?: 25;
		$chosenAreaMax = (int) $paramAreaRange[1] ?: 70;
		
	#	$paramCostRange = explode(',', $_REQUEST['param_cost_range']);
		$paramCostRange = $_REQUEST['param_cost_range'];
		$chosenCostMin = (float) $paramCostRange[0] ?: 1000000;
		$chosenCostMax = (float) $paramCostRange[1] ?: 5000000;
		
		$chosenCostMin *= 1000000;
		$chosenCostMax *= 1000000;
		
	#	print_r($_REQUEST);
		
		foreach ($xml->offer as $offer) {
			$status = (string) $offer->status;
			if ($status == 'SOLD') continue;
		#	Using 'explode' because this row is a string value that couldn't be converted to integer. idk why
			$section = (int) explode(' ', $offer->{'building-section'})[1];
		#	Old
		#	if ($chosenSection && !$chosenSection[$section]) continue;
			if ($chosenSection && $chosenSection != $section) continue;
			
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
				'price' => number_format($price, 0, '', ' ' ),
				'number' => (int) $offer->number
			];
		}
	}
	if ($requestType == 2) {
		if ($_REQUEST['param_number']) $chosenApartment = (int) $_REQUEST['param_number'];
		if (!$chosenApartment) return [];
		
		foreach ($xml->offer as $offer) {
			$apartment = (int) $offer->number;
			if ($apartment == $chosenApartment) {
				$data = [
					'section' => (int) explode(' ', $offer->{'building-section'})[1],
					'floor' => (int) $offer->{'floor'},
					'rooms' => (int) $offer->rooms,
					'area' => (string) $offer->area->value,
					'price' => number_format((int) $offer->price->value, 0, '', ' ' ),
					'number' => $apartment
				];
				break;
			} else {
				continue;
			}
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