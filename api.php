<?php
include "kernel/load.php";
header('Content-Type: application/json');
		
		$ids = array();
		
		$fetch = query('SELECT r.id_ruta, r.ps, s.loc
						FROM rute r
						INNER JOIN statii s ON (s.id = r.id_statie AND (loc LIKE "%Bucuresti%" OR loc LIKE "%Sibiu%"))
						ORDER BY r.id_statie, r.ps');
		
		$statii = array();
		
		while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
			var_dump($row);
			if($row['ps'] == "1") $statii[$row['id_ruta']] = "Bucuresti";
			else $ids[] = $row['id_ruta'];
		};

		$fetch2 = query('SELECT r.*, MAX( ps )
						FROM rute r
						INNER JOIN statii s ON (s.id = r.id_statie)
						WHERE r.id_ruta IN ('.implode($ids,",").')
						GROUP BY r.id_ruta');
						
		while ($row = mysql_fetch_array($fetch2, MYSQL_ASSOC)) {
			print_r($row);
		};


/*
$to = mysql_real_escape_string(@$_REQUEST["to"]);
$from = mysql_real_escape_string(@$_REQUEST["from"]);






		$fetch = query("SELECT * 
						FROM rute AS r
						INNER JOIN statii AS s ON r.id_statie = s.id
						INNER JOIN operatori AS o ON r.id_operator = o.id
						LIMIT 0 , 30
						");
		$statii = array();
		while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
		    $row_array['id'] = $row['id'];
		    $row_array['nume'] = $row['nume'];
		    $row_array['locatie'] = $row['loc'];

		    array_push($statii,$row_array);
	}
*/

/* SELECT * 
FROM rute AS r
INNER JOIN statii AS s ON r.id_statie = s.id
INNER JOIN operatori AS o ON r.id_operator = o.id
WHERE loc LIKE '%Bucuresti%' and loc like '%sibiu%' group by id_ruta
*/

