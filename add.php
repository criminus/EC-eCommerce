<?php
//Load Config
require 'includes/db.php';
//Load Twig
require 'includes/autoload.php';
//Add cart function
require 'includes/add_functions.php';

//Start Session
session_start();

//Check if the product_id is set
$id = '';
$template = 'add.twig';
$item_info = '';

//Check if the item_id is set and the user is actually logged in
if ((isset($_GET['product_id'])) && (isset($_SESSION['loggedin']) && $_SESSION['loggedin'])) {
    $id = $_GET['product_id'];

    //Before adding the item, we check the last added item from the session
    if (isset($_SESSION['last_added_item']) && $_SESSION['last_added_item'] == $id) {
        //Change the template to a warning one
        $template = 'warning.twig';
    } else {
        addItemToCart($id);
        $item_info = getItemInfo($id);
        $template = 'add.twig';
    }

} else {
    $template = 'error.twig';
}

// Load Navigation
$navigation = include 'navigation.php';

// Merge the navigation data with other data to pass to Twig
$data = array_merge($navigation, [
    'sitename'              => 'MK Time',
    'pageTitle'             => 'Add item',
    'item'                  => $item_info
]);

// Render the template
echo $twig->render($template, $data);