<?php
session_start();

require_once 'db_connect.php';

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare('SELECT orders.ORDERID, orders.ORDERDATE, orders.TOTALPRICE, menu.NAME, order_items.QUANTITY, order_items.PRICE 
FROM orders 
JOIN order_items ON orders.ORDERID = order_items.ORDERID
JOIN menu ON order_items.ITEMID = menu.ITEMID
WHERE orders.USERID = :user_id
ORDER BY orders.ORDERDATE DESC');

$stmt->execute(['user_id' => $userId]);
$orderHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($orderHistory);
?>