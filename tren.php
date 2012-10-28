<?php 

	class Trenuri
	{
		public function __contruct()
		{

		}


		public function getJson($plecare, $sosire)
		{
			$url = 'http://merstrenuri.ro/Lmb=Xml?Ple=' . $plecare . '&Sos=' . $sosire . '&Via=&Sub=Rute&Tpe=on&Tra=on&Tin=on&Ast=3&Dac=15641&Tof=on';
			$xml = simplexml_load_file($url);
			$retArr = array();

			$results = $xml->xpath('//Ruta');

			foreach($results as $result){

				$tip
				$nr
				$plecare
				$statie_plecare
				$sosire
				$statie_sosire

				$retArr[]  = array(
									'tip' =>  $result->Tren->Itren->attributes()->tip->__toString(),
									'nr' => $result->Tren->Itren->attributes()->nr->__toString(),
									'plecare' => $result->Tren->Plecare->attributes()->ora->__toString(),
									'statie_plecare' => $result->Tren->Plecare->attributes()->sta->__toString(),
									'sosire' => $result->Tren->Sosire->attributes()->ora->__toString(),
									'statie_sosire' => $result->Tren->Sosire->attributes()->sta->__toString(),
									//'asteptare' => $result->Tren->Asteptare->attributes()->min->__toString(),




				 );
				print_r($retArr);
			}
			print_r($retArr);
			//echo json_encode($result);
			return json_encode($xml);
			
		}
	}


	$tren = new Trenuri();

	$tren->getJson('Bucuresti+Nord', 'Sinaia');

	if(!isset($_REQUEST['plecare']) && !isset($_REQUEST['sosire']) ){ exit('Ups!'); }
	$tren->getJson($_REQUEST['plecare'], $_REQUEST['sosire']);