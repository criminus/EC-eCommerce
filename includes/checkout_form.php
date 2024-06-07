<?php
//Include Form Control Functions
require 'checkout_functions.php';

//Start the session to get any errors during process
session_start();

//Check inputs and call the register function
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $errors = [];

    //Define inputs
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    //Get any errors & create user
    $errors = checkout($user_id);

    //Check for errors
    if (empty($errors)) {
        header("Location: ../checkout.php?success=true");
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: ../checkout.php?error=true");
        exit();
    }
} else {
    header("Location: ../checkout.php?error=true");
    exit();
}