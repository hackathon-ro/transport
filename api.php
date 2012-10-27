<?php
include "kernel/load.php";
header('Content-Type: application/json');

$name = mysql_real_escape_string($_REQUEST["name"]);

/* de aici incepe */
if(!isset($_REQUEST['what'])){ exit('da fuck?'); }
	switch($_REQUEST['what']){
		case "search":


		$fetch = query("SELECT * FROM `statii` WHERE `nume` LIKE '%$name%'");
		$statii = array();
		while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
		    $row_array['id'] = $row['id'];
		    $row_array['nume'] = $row['nume'];
		    $row_array['loc'] = $row['loc'];

		    array_push($statii,$row_array);
	}

echo json_encode($statii);

		break;
		case "id":
   
			//echo $_REQUEST['name'];

		break;


     }