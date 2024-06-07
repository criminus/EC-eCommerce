<?php
//Register Form Control

//Include Form Control Functions
require 'feedback_functions.php';

//Start the session to get any errors during process
session_start();

//Check inputs and call the register function
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $errors = [];

    //Define inputs
    $user_id        = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $feedback       = isset($_POST['feedbackMessage']) ? $_POST['feedbackMessage'] : '';
    $product_id     = isset($_POST['product_id']) ? $_POST['product_id'] : 0;
    
    if ($user_id == null) {
        $errors[] = "User id can't be null!";
    }

    //Get any errors & create user
    $errors = submitFeedback($user_id, $product_id, $feedback);

    //Check for errors
    if (empty($errors)) {
        header("Location: ../product.php?product_id=$product_id&success=true");
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: ../product.php?product_id=$product_id&error=true");
        exit();
    }
} else {
    header("Location: ../product.php?product_id=$product_id&error=true");
    exit();
}