<?php
//Include config for database query
require 'db.php';

function submitFeedback(
    $user_id, 
    $product_id, 
    $feedback
) {
    //global pdo
    global $pdo;

    try {
        //First we want to make sure this user didn't submit any feedback for this item already

        $query = 'SELECT * FROM feedback WHERE user_id = :user_id AND product_id = :product_id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $entry = $stmt->fetch(PDO::FETCH_ASSOC);

        //If there is any entry, return false
        if ($entry) {
            return ["You've already posted your feedback for this item."];
        } else {
        //If there are no entries, we submit the feedback
            $query = 'INSERT INTO feedback (user_id, product_id, feedback) VALUES (:user_id, :product_id, :feedback)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':feedback', $feedback, PDO::PARAM_STR);
            $stmt->execute();
        }

    } catch (PDOException $e) {
        die('Error submitting feedback' . $e->getMessage());
    }
}