<?php

function addItemToCart(
    $id
) {
    //Global pdo
    global $pdo;

    try {
        //First we check if this item exists
        $query = 'SELECT * FROM products WHERE product_id = :product_id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        //Check if item found with this id
        if ($item) {
            //Item exists so we do another query to update this user's cart
            $user_id = $_SESSION['user_id'];
            //Make sure the item_price is float not integer
            $price = number_format((float)$item['price'], 2, '.', '');
            //We will use ON DUPLICATE KEY to check if product_id already exists for this user and update quantity by 1
            $query  = 'INSERT INTO basket (user_id, product_id, quantity, total) VALUES (:user_id, :product_id, 1, :price)
                    ON DUPLICATE KEY UPDATE quantity = quantity + 1, total = total + VALUES(total)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->execute();

            //To prevent refresh exploit, we store the last_added_item in the session
            $_SESSION['last_added_item'] = $id;

        } else {
            return false;
        }

    } catch (PDOException $e) {
        die('Error querying the database: '. $e->getMessage());
    }
}

function removeItem(
    $id
) {
    // Global pdo
    global $pdo;

    try {
        // First, check if this item exists in the user's basket
        $user_id = $_SESSION['user_id'];
        $query = 'SELECT * FROM basket WHERE user_id = :user_id AND product_id = :product_id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $basketItem = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the item is in the basket
        if ($basketItem) {
            if ($basketItem['quantity'] > 1) {
                // Calculate price per item
                $pricePerItem = $basketItem['total'] / $basketItem['quantity'];

                // Decrease quantity by 1 and update total price
                $query = 'UPDATE basket 
                            SET quantity = quantity - 1, 
                            total = total - :price 
                            WHERE user_id = :user_id AND product_id = :product_id';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':price', $pricePerItem, PDO::PARAM_STR);
                $stmt->execute();
            } else {
                // Remove the item completely from the basket
                $query = 'DELETE FROM basket WHERE user_id = :user_id AND product_id = :product_id';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
                $stmt->execute();
            }
        } else {
            return false; 
        }

    } catch (PDOException $e) {
        die('Error querying the database: ' . $e->getMessage());
    }
}


//While adding the item to the cart, we would like to actually see which item and its details so we don;t confuse the customer
function getItemInfo(
    $id
) {
    //Get PDO inside the function using global
    global $pdo;
    
    try {
        $query = 'SELECT * FROM products WHERE product_id = :product_id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        return $item;

    } catch (PDOException $e) {
        die('Error fetching items' . $e->getMessage());
    }
}