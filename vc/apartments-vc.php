<?php
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

$wtf = DB::getPDO()->query('SELECT * FROM people LIMIT 1')->fetch(2);

/*
$data = [];
	#	$source = $this->GetSourceFromURL('http://pb3027.profitbase.ru/export/profitbase_xml/1417637d6bd49b6877cddf7f37e15876');
		$source = $this->GetSourceFromURL('http://pb4850.profitbase.ru/export/profitbase_xml/f1f41fb5c65a9d873f7d4c5986f42423');
		$xml = simplexml_load_string($source);
		$data['floors_count'] = (int) $xml->offer->house->{'floors-total'};
		$data['offers_count'] = count($xml->offer);
		$data['apartments'] = [];
		foreach($xml->offer as $offer) {
			$section = (int) $offer->{'building-section'};
			$apart_num = (int) $offer->{'number'};
			$data['apartments'][$section][$apart_num] = array(
				'floor' => (int) $offer->{'floor'},
				'rooms' => (int) $offer->rooms,
				'area' => (string) $offer->area->value,
				'price_length' => (int) $offer->{'price-meter'}->value,
				'status' => ((string) $offer->status == 'SOLD') ? 0 : 1,
				'image' => (string) $offer->image,
				'price' => (int) $offer->price->value,
			);
		}
		$json = $data;
	#	$json = $this->FriendlyJson($data);
		return response($json, 200)->header('Content-Type', 'application/json');;
	}
	
	
	private function GetSourceFromURL($url) {
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => 2
		));
		$result = curl_exec($ch); curl_close($ch);
		return $result;
	}*/
	
	#$wtf = 'heyeh';