<?php
//Include config for database query
require 'db.php';

function checkCustomer(
    $pdo,
    $email,
    $password
) 
{
    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    //Define empty errors array to hold any errors
    $errors = [];

    //Check for empty inputs
    if (empty($email)) {
        $errors[] = 'Please enter your email address.'; 
    }

    if (empty($password)) {
        $errors[] = 'Please enter your password.'; 
    }

    //If empty errors, we procceed to the login
    if (empty($errors)) {
        try {
            //Check credentials
            $stmt = $pdo->prepare("SELECT user_id, first_name, last_name, pass, email FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && $password == $user['pass']) {
                //If login is correct, set session, email and redirect user
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name']  = $user['last_name'];
                $_SESSION['user_id'] = $user['user_id'];

                header("Location: ../login.php?success=true");
                exit;
            } else {
                $errors[] = 'Incorrect credentials. Please check and try again.';
            }
        } catch (PDOException $e) {
            $errors[] = 'Database error' . $e->getMessage();
        }
    }

    return $errors;
}