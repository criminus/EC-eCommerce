<?php
//Include config for database query
require 'db.php';

function registerUser(
    $pdo, 
    $first_name, 
    $last_name, 
    $password, 
    $conf_password, 
    $email
)
{
    //Define empty errors array to hold any errors
    $errors = [];

    //Check if first name is empty
    if (empty($first_name)) {
        $errors[] = 'First Name field can\'t be empty!'; 
    }

    //Check if last name is empty
    if (empty($last_name)) {
        $errors[] = 'Last Name field can\'t be empty!'; 
    }

    //Check if passwords don't match
    if ($password !== $conf_password) {
        $errors[] = 'Passwords don\'t match!';
    }

    //Validate email using FILTER_VALIDATE_EMAIL
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'The email address is not valid.';
    }

    //Check if this person has already an account with us:
    $stmt = $pdo->prepare('SELECT first_name, last_name, email FROM users WHERE first_name = ? AND last_name = ? OR email = ?');
    $stmt->execute([$first_name, $last_name, $email]);
    $userCheck = $stmt->fetch(PDO::FETCH_ASSOC);

    //Check here
    if ($userCheck) {
        $errors[] = 'There is already a customer with this name or email.';
    }

    //If there are no errors, we create the account with the given data:
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, pass, email, reg_date) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$first_name, $last_name, $password, $email]);
        } 
        catch (PDOException $e) {
            $errors[] = 'Database error ' . $e->getMessage();
        }
    }

    //Finally we return the errors
    return $errors;
}