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




			var_dump($xml);
		}
	}


	$tren = new Trenuri();

	$tren->getJson('Bucuresti+Nord', 'Sinaia');