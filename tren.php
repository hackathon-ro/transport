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

				if(!is_null($result->Tren->Itren)){
					$tip 					= $result->Tren->Itren->attributes()->tip->__toString();
				}
				if(isset($result->Tren->Itren)){
					$nr 					= $result->Tren->Itren->attributes()->nr->__toString();
				}
				if(isset($result->Tren->Plecare)){
					$plecare 				= $result->Tren->Plecare->attributes()->ora->__toString();
				}
				if(isset( $result->Tren->Plecare)){
					$statie_plecare 		= $result->Tren->Plecare->attributes()->sta->__toString();
				}
				if(isset($result->Tren->Sosire)){
					$sosire 				= $result->Tren->Sosire->attributes()->ora->__toString();
				}
				if(isset($result->Tren->Sosire)){
					$statie_sosire 			= $result->Tren->Sosire->attributes()->sta->__toString();
				}
				if(isset($result->Tren->Asteptare)){
					$asteptare = $result->Tren->Asteptare->attributes()->min->__toString();
				}

				$retArr[]  = array(
									'tip' 				=> $tip,
									'nr' 				=> $nr,
									'plecare' 			=> $plecare,
									'statie_plecare' 	=> $statie_plecare,
									'sosire' 			=> $sosire,
									'statie_sosire' 	=> $statie_sosire,
									'asteptare' 		=> $asteptare


				 );
				//print_r($retArr);
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