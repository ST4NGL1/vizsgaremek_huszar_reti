<?php
session_start();
include 'db_connect.php'; 

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Felhasználó nincs bejelentkezve']);
    exit();
}

$userId = $_SESSION['user_id'];
$checkoutData = json_decode(file_get_contents('php://input'), true);
$cartItems = $checkoutData['cartItems'];
$totalPrice = 0;


foreach ($cartItems as $item) {
 
    $stmt = $pdo->prepare("SELECT PRICE FROM menu WHERE ITEMID = ?");
    $stmt->execute([$item['itemId']]);
    $price = $stmt->fetchColumn();
    $totalPrice += $price * $item['quantity'];
    $item['price'] = $price; 
}

try {
    $pdo->beginTransaction();

    
    $orderDate = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("INSERT INTO orders (USERID, ORDERDATE, TOTALPRICE) VALUES (?, ?, ?)");
    $stmt->execute([$userId, $orderDate, $totalPrice]);
    $orderId = $pdo->lastInsertId();

  
    foreach ($cartItems as $item) {
        $stmt = $pdo->prepare("INSERT INTO order_items (ORDERID, ITEMID, QUANTITY, PRICE) VALUES (?, ?, ?, ?)");
        $stmt->execute([$orderId, $item['itemId'], $item['quantity'], $price]);
    }

    $stmt = $pdo->prepare("DELETE FROM cart WHERE USERID = ?");
    $stmt->execute([$userId]);

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>