<?php
//Include config for database query
require 'db.php';

function checkout(
    $userId
) {
    //global pdo
    global $pdo;
    try {
        // Start transaction
        $pdo->beginTransaction();

        //Get items from the bascket
        $query = 'SELECT b.product_id, b.total, b.quantity
                FROM basket b
                WHERE b.user_id = :user_id';
        $stmt = $pdo->prepare($query);
        $stmt->execute(['user_id' => $userId]);
        $basketItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Get total amount
        $totalAmount = 0;
        foreach ($basketItems as $item) {
            $totalAmount += $item['total'];
        }

        //Create a new order record
        $query = 'INSERT INTO orders (user_id, order_date, total_amount) VALUES (:user_id, NOW(), :total_amount)';
        $stmt = $pdo->prepare($query);
        $stmt->execute(['user_id' => $userId, 'total_amount' => $totalAmount]);

        // Get the last inserted order_id
        $orderId = $pdo->lastInsertId();

        //Insert items into the order_details table
        $query = 'INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)';
        $stmt = $pdo->prepare($query);

        foreach ($basketItems as $item) {
            $stmt->execute([
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['total'] / $item['quantity']
            ]);
        }

        // Clear the basket for the user
        $query = 'DELETE FROM basket WHERE user_id = :user_id';
        $stmt = $pdo->prepare($query);
        $stmt->execute(['user_id' => $userId]);

        // Commit transaction
        $pdo->commit();

    } catch (Exception $e) {
        // Rollback transaction on error
        $pdo->rollBack();
        die("Failed to place order: " . $e->getMessage());
    }
}