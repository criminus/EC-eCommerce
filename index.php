<?php
//Load db file
require 'includes/db.php';
//Load twig
require 'includes/autoload.php';

//start session
session_start();

//Include navigation
$navigation = include 'navigation.php';

// Merge the navigation data with other data to pass to Twig
$data = array_merge($navigation, [
    'sitename'              => 'MKTime',
    'pageTitle'             => 'Home',
]);

// Render the template
echo $twig->render('index.twig', $data);