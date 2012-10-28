<?php 

	class Trenuri
	{

		var $retArr = array();

		public function __contruct()
		{

		}


		public function getJson($from, $to)
		{

			$url = file_get_contents('http://merstrenuri.ro/Lmb=Xml?Ple=' . $from . '&Sos=' . $to . '&Via=&Sub=Rute&Tpe=on&Tra=on&Tin=on&Ast=3&Dac=15641&Tof=on');
			$xml = simplexml_load_file($url);

			$this->retArr = array();

			$retArr = array();
			$possibleFrom = array();
			$possibleTo = array();

			$sugestionUrl = 'http://merstrenuri.ro/Lmb=Xml?Sub=Help';

			$xmlSugestion = simplexml_load_file($sugestionUrl);
			//$xmlSugestion->translate();
			//print_r($xmlSugestion);
			//echo '<hr>';
			$wildcard = $from;
			$results = $xmlSugestion->xpath('//Statie[contains(@nume,"' . $wildcard . '")]');

			foreach($results as $result){

				$possibleFrom[] = $result->attributes()->nume->__toString();

			}

			$wildcard = $to;
			$results = $xmlSugestion->xpath('//Statie[contains(@nume,"' . $wildcard . '")]');

			foreach($results as $result){

				$possibleTo[] = $result->attributes()->nume->__toString();

			}
			
		//print_r( $possibleFrom );
		//	print_r( $possibleTo );


			foreach($possibleFrom as $from)
			{
				foreach($possibleTo as $to)
				{
					
					$this->getTrips(str_replace(' ', "+", $from), str_replace(' ', "+", $to));
				}
			}

			
			echo json_encode(array( 'trenuri' => $this->retArr));
			
		}

		private function getTrips($from, $to)
		{
				$url = 'http://merstrenuri.ro/Lmb=Xml?Ple=' . $from . '&Sos=' . $to . '&Via=&Sub=Rute&Tpe=on&Tra=on&Tin=on&Ast=3&Dac=15641&Tof=on';
				$xml = @simplexml_load_file($url);

				if($xml){
			

			//$results = $xml->xpath('//Ruta');
  			
			foreach($results->item as $result){

				//print_r($result);
				//echo '<hr>';
				$tip = "";
				$nr = "";
				$plecare = "";
				$statie_plecare = "";
				$sosire = "";
				$statie_sosire = "";
				$asteptare = "";

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
				if(!empty($nr))
				{
				$this->retArr[]  = array(
									'tip' 				=> $tip,
									'nr' 				=> $nr,
									'plecare' 			=> $plecare,
									'statie_plecare' 	=> $statie_plecare,
									'sosire' 			=> $sosire,
									'statie_sosire' 	=> $statie_sosire,
									'asteptare' 		=> $asteptare


				 );
				}
				
			}

		}
		}
	}

	$tren = new Trenuri();
	//$tren->getJson($_REQUEST['from'], $_REQUEST['to']);
	

	//$tren->getJson('Bucuresti Nord', 'Sinaia');

	 if(!isset($_REQUEST['from']) && !isset($_REQUEST['to']) ){ exit('Ups!'); }

	// $tren = new Trenuri();
	 $tren->getJson($_REQUEST['from'], $_REQUEST['to']);
