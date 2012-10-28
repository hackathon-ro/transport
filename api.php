<?php
include "kernel/load.php";
header('Content-Type: application/json');

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


/* SELECT * 
FROM rute AS r
INNER JOIN statii AS s ON r.id_statie = s.id
INNER JOIN operatori AS o ON r.id_operator = o.id
WHERE loc LIKE '%Bucuresti%' and loc like '%sibiu%' group by id_ruta
*/

