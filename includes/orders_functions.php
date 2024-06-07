<?php

//Include config for database query
require 'db.php';

function previousOrders(
    $user_id
) {
    //global pdo
    global $pdo;
    
    try {
        $query = 'SELECT * FROM orders WHERE user_id = :user_id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $orders;

    } catch (PDOException $e) {
        die('Error fetching previous orders' . $e->getMessage());
    }
}
