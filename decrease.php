<?php
//Load Config
require 'includes/db.php';
//Load Twig
require 'includes/autoload.php';
//Add cart function
require 'includes/add_functions.php';

//Start Session
session_start();

//Check if the item_id is set and the user is actually logged in
if ((isset($_GET['product_id'])) && (isset($_SESSION['loggedin']) && $_SESSION['loggedin'])) {
    $id = $_GET['product_id'];

    removeItem($id);

    //Redirect user back to cart once updated.
    header("Location: cart.php");
    exit();

} else {
    header("Location: login.php");
    exit();
}