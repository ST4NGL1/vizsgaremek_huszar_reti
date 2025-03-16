<?php
session_start();

require_once 'db_connect.php';

$userId = $_SESSION['user_id'];

// Clear the cart for the user
$stmt = $pdo->prepare('DELETE FROM cart WHERE USERID = :user_id');
$stmt->execute(['user_id' => $userId]);

echo json_encode(['success' => true, 'message' => 'Checkout successful']);
?>