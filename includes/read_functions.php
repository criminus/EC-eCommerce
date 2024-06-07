<?php

//Include config file for database query
require 'db.php';

//Define the getItems function
function getItems(
) {
    //Get PDO inside the function using global
    global $pdo;
    
    try {
        $stmt = $pdo->prepare('SELECT * FROM products');
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $items;

    } catch (PDOException $e) {
        die('Error fetching items' . $e->getMessage());
    }
}

//Get item name by id
function getProductDetails(
    $id
) {
    //global pdo
    global $pdo;

    try {
        $query = 'SELECT * FROM products WHERE product_id = :product_id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        return $item;

    } catch (PDOException $e) {
        die('Error fetching data for this item' . $e->getMessage());
    }
}

function getFeedback(
    $id
) {
    //global pdo
    global $pdo;

    try { 
        $query = 'SELECT * FROM feedback WHERE product_id = :product_id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $feedback = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $feedback;

    } catch (PDOException $e) {
        die('Error while fetching feedback data for this item: ' . $e->getMessage());
        return [];
    }
}

function getFeedbackCount(
    $id
) {
    //global pdo
    global $pdo;

    try {
        $query = 'SELECT COUNT(*) AS total_feedback FROM feedback WHERE product_id = :product_id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC);

        //Return results and if none, set to 0
        return $total && $total['total_feedback'] !== null ? $total['total_feedback'] : 0;

    } catch (PDOException $e) {
        die('Error getting the total feedback for this item' . $e->getMessage());
    }

}