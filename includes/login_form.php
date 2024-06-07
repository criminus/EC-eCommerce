<?php
//Login Form Control

//Include login functions
require 'login_functions.php';

//Start the session to get any errors during process
session_start();

//Check inputs and call the login function
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Define inputs
    $email          = isset($_POST['emailAddress']) ? $_POST['emailAddress'] : '';
    $password       = isset($_POST['password']) ? $_POST['password'] : '';
    
    //Get any errors & create user
    $errors = checkCustomer($pdo, $email, $password);

    //Check for errors
    if (empty($errors)) {
        header("Location: ../login.php?success=true");
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: ../login.php?error=true");
        exit();
    }
} else {
    header("Location: ../login.php?error=true");
    exit();
}