<?php
session_start();
include 'db_connect.php'; // Ensure this file is correctly named and included

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$userId = $_SESSION['user_id'];
$checkoutData = json_decode(file_get_contents('php://input'), true);
$cartItems = $checkoutData['cartItems'];
$totalPrice = 0;

// Calculate total price
foreach ($cartItems as $item) {
    // Fetch the price from the database to ensure accuracy
    $stmt = $pdo->prepare("SELECT PRICE FROM menu WHERE ITEMID = ?");
    $stmt->execute([$item['itemId']]);
    $price = $stmt->fetchColumn();
    $totalPrice += $price * $item['quantity'];
    $item['price'] = $price; // Add the correct price to the item
}

try {
    $pdo->beginTransaction();

    // Insert order into orders table
    $orderDate = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("INSERT INTO orders (USERID, ORDERDATE, TOTALPRICE) VALUES (?, ?, ?)");
    $stmt->execute([$userId, $orderDate, $totalPrice]);
    $orderId = $pdo->lastInsertId();

    // Insert order items into order_items table
    foreach ($cartItems as $item) {
        $stmt = $pdo->prepare("INSERT INTO order_items (ORDERID, ITEMID, QUANTITY, PRICE) VALUES (?, ?, ?, ?)");
        $stmt->execute([$orderId, $item['itemId'], $item['quantity'], $price]);
    }

    // Clear the cart
    $stmt = $pdo->prepare("DELETE FROM cart WHERE USERID = ?");
    $stmt->execute([$userId]);

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>