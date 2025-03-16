<?php
session_start();
include 'db_connection.php'; // Include your database connection file

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$userid = $_SESSION['user_id'];
$cart = json_decode(file_get_contents('php://input'), true)['cartItems'];
$totalPrice = 0;

// Calculate total price
foreach ($cart as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

// Insert order into orders table
$orderDate = date('Y-m-d H:i:s');
$sql = "INSERT INTO orders (USERID, ORDERDATE, TOTALPRICE) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isi", $userid, $orderDate, $totalPrice);
$stmt->execute();
$orderID = $stmt->insert_id;

// Insert order items into order_items table
foreach ($cart as $item) {
    $sql = "INSERT INTO order_items (ORDERID, ITEMID, QUANTITY, PRICE) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $orderID, $item['ITEMID'], $item['quantity'], $item['price']);
    $stmt->execute();
}

// Clear the cart
unset($_SESSION['cart']);

echo json_encode(['success' => true]);
?>