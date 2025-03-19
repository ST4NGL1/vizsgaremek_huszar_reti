<?php
session_start();

require_once 'db_connect.php';

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemId = $_POST['item_id'];
    $quantity = $_POST['quantity'];

    $stmt = $pdo->prepare('UPDATE cart SET QUANTITY = :quantity WHERE USERID = :user_id AND ITEMID = :item_id');
    $stmt->execute(['quantity' => $quantity, 'user_id' => $userId, 'item_id' => $itemId]);

    echo json_encode(['status' => 'success']);
    exit;
}

$stmt = $pdo->prepare('SELECT cart.ITEMID, menu.NAME, menu.PRICE, cart.QUANTITY 
FROM cart 
JOIN menu ON cart.ITEMID = menu.ITEMID
WHERE cart.USERID = :user_id');

$stmt->execute(['user_id' => $userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($cartItems);
?>
