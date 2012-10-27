<?php

global $twig;

require_once 'lib/Twig/Autoloader.php';
require_once 'functions.php';

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('html');
$twig = new Twig_Environment($loader, array( 'cache' => false ));
$twig->addGlobal('fn', new fn());
