<?php
//Load Config
require 'includes/db.php';
//Load Twig
require 'includes/autoload.php';
//Add cart function
require 'includes/checkout_functions.php';

//Start Session
session_start();

// Load Navigation
$navigation = include 'navigation.php';

//Get errors generated while registration
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['errors']);

// Merge the navigation data with other data to pass to Twig
$data = array_merge($navigation, [
    'sitename'              => 'MK Time',
    'pageTitle'             => 'Checkout',
    'errors'                => $errors,
]);

// Render the template
echo $twig->render('checkout.twig', $data);