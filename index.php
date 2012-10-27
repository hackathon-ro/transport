<?php

session_start();

include "includes/config.php";

$subpage = isset($_GET['p']) ? $_GET['p'] : "index";
$isModal = isset($_GET['modal']) ? true : false;
$session = $_SESSION;

$page_path = "pages:$subpage.html.twig";
if($isModal) $page_path = "dialogs:$subpage.html.twig";

twig_render($page_path,array("page"=>$subpage,"server" => $_SERVER, "request" => $_REQUEST, "session" => $session));
 
?>