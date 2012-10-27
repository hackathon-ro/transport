<?php 
include "kernel/load.php";
header('Content-Type: application/json');
$test = array('1' => "cluj", 
			  '2' =>"$_REQUEST[name]"
			  );
if(!isset($_REQUEST['what'])){ exit('da fuck?'); }
	switch($_REQUEST['what']){
		case "from":
  
			echo json_encode($test);

		break;
		case "to":
   
			echo $_REQUEST['name'];

		break;


     }