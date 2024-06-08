<?php
//Load Config
require 'includes/db.php';
//Load Twig
require 'includes/autoload.php';

require 'includes/cart_functions.php';

//Start Session
session_start();

if ((isset($_SESSION['loggedin']) && $_SESSION['loggedin'])) {
    $user_id = $_SESSION['user_id'];
    $my_items = getBasket($user_id);
    $total_cart = getTotal($user_id);
    $template = 'cart.twig';
} else {
    $my_items = '';
    $total_cart = '';
    $template = 'error.twig';
}

//if we are returning to the shop, we reset the last_added_item
$_SESSION['last_added_item'] = '';

// Load Navigation
$navigation = include 'navigation.php';

// Merge the navigation data with other data to pass to Twig
$data = array_merge($navigation, [
    'sitename'              => 'MK Time',
    'pageTitle'             => 'My cart',
    'items'                 => $my_items,
    'total'                 => $total_cart
]);

// Render the template
echo $twig->render($template, $data);