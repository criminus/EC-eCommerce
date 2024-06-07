<?php
//Load db file
require 'includes/db.php';
//Load twig
require 'includes/autoload.php';

//Start Session
session_start();

// Load Navigation
$navigation = include 'navigation.php';

//Get errors generated while registration
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['errors']);

//Handle form errors & submit
$form_message = '';
$form_message_type = '';

if (isset($_GET['success']) && $_GET['success'] == 'true') {
    $form_message = 'Successfuly loged in! You will now be redirected!';
    $form_message_type = 'success';

    //Redirect to home
    header("refresh:1, url=index.php");
    
} elseif (isset($_GET['error']) && $_GET['error'] == 'true') {
    $form_message = 'Something went wrong. Please try again. If the problem persist, please contact the Administrator.';
    $form_message_type = 'danger';
}

// Merge the navigation data with other data to pass to Twig
$data = array_merge($navigation, [
    'sitename'              => 'MK Time',
    'pageTitle'             => 'Sign In',
    'errors'                => $errors,
    'form_message'          => $form_message,
    'form_message_type'     => $form_message_type,
]);

// Render the template
echo $twig->render('login.twig', $data);