<?php
session_start();

require_once 'db_connect.php';

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare('SELECT cart.ITEMID, menu.name, menu.price 
FROM cart 
JOIN menu ON cart.ITEMID = menu.id
WHERE cart.USERID = :user_id');

$stmt->execute(['user_id' => $userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($cartItems);
?>
