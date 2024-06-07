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

//Get errors generated while registration
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['errors']);

//if we are returning to the shop, we reset the last_added_item
$_SESSION['last_added_item'] = '';

// Load Navigation
$navigation = include 'navigation.php';

//Set some default values
$id = '';
$template = 'error.twig';
$page_title = '';
$product_id = '';
$product_desc = '';
$product_price = '';
$product_sale = '';
$product_discount = '';
$product_feedback = '';
$total_feedback = '';

if ((isset($_GET['product_id']))) {
    $id = $_GET['product_id'];
    $template = 'product.twig';
    $page_title = getProductDetails($id)['product_name'];
    $product_id = getProductDetails($id)['product_id'];
    $product_desc = getProductDetails($id)['description'];
    $product_price = getProductDetails($id)['price'];
    $product_sale = getProductDetails($id)['sale'];
    $product_discount = getProductDetails($id)['discount'];
    $product_feedback = getFeedback($id);
    $total_feedback = getFeedbackCount($id);

} else {
    //We don't have an existing item so we don't query the database
    //Setting everything to empty
    $id = '';
    $template = 'error.twig';
    $page_title = '';
    $product_id = '';
    $product_desc = '';
    $product_price = '';
    $product_sale = '';
    $product_discount = '';
    $product_feedback = '';
    $total_feedback = '';
}

// Merge the navigation data with other data to pass to Twig
$data = array_merge($navigation, [
    'sitename'              => 'MK Time',
    'pageTitle'             => $page_title,
    'product_id'            => $product_id,
    'product_desc'          => $product_desc,
    'product_price'         => $product_price,
    'product_sale'          => $product_sale,
    'product_discount'      => $product_discount,
    'product_feedback'      => $product_feedback,
    'total_feedback'        => $total_feedback,
    'errors'                => $errors,
]);

// Render the template
echo $twig->render($template, $data);