<?php
session_start();

require_once 'db_connect.php';

$userId = $_SESSION['user_id'];
$itemId = json_decode(file_get_contents('php://input'), true)['itemId'];

$stmt = $pdo->prepare('DELETE FROM cart WHERE USERID = :user_id AND ITEMID = :item_id');
$stmt->execute(['user_id' => $userId, 'item_id' => $itemId]);

echo json_encode(['success' => true]);
?>