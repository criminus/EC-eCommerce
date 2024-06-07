<?php
//Register Form Control

//Include Form Control Functions
require 'register_functions.php';

//Start the session to get any errors during process
session_start();

//Check inputs and call the register function
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Define inputs
    $first_name     = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $last_name      = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $password       = isset($_POST['password']) ? $_POST['password'] : '';
    $conf_password  = isset($_POST['confPassword']) ? $_POST['confPassword'] : '';
    $email          = isset($_POST['emailAddress']) ? $_POST['emailAddress'] : '';
    
    //Get any errors & create user
    $errors = registerUser($pdo, $first_name, $last_name, $password, $conf_password, $email);

    //Check for errors
    if (empty($errors)) {
        header("Location: ../register.php?success=true");
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: ../register.php?error=true");
        exit();
    }
} else {
    header("Location: ../register.php?error=true");
    exit();
}