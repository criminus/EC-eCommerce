<?php
//Load Config
require 'includes/db.php';
//Load Twig
require 'includes/autoload.php';

//Load orders function
require 'includes/orders_functions.php';

//Start Session
session_start();

$prev_preders = '';
if ((isset($_SESSION['loggedin']) && $_SESSION['loggedin'])) {
    $user_id        = $_SESSION['user_id'];
    $template       = 'orders.twig';
    $prev_preders   = previousOrders($user_id);
} else {
    $template = 'error.twig';
}

//if we are returning to the shop, we reset the last_added_item
$_SESSION['last_added_item'] = '';

// Load Navigation
$navigation = include 'navigation.php';

// Merge the navigation data with other data to pass to Twig
$data = array_merge($navigation, [
    'sitename'              => 'MK Time',
    'pageTitle'             => 'My orders',
    'previousOrders'        => $prev_preders,
]);

// Render the template
echo $twig->render($template, $data);