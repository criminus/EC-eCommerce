<?php
//Load Config
require 'includes/db.php';
//Load Twig
require 'includes/autoload.php';

//Require read items function file
require 'includes/read_functions.php';

//Start Session
session_start();

//if we are returning to the shop, we reset the last_added_item
$_SESSION['last_added_item'] = '';

// Load Navigation
$navigation = include 'navigation.php';

// Merge the navigation data with other data to pass to Twig
$data = array_merge($navigation, [
    'sitename'              => 'MK Time',
    'pageTitle'             => 'Our products',
    'items'                 => getItems()
]);

// Render the template
echo $twig->render('products.twig', $data);