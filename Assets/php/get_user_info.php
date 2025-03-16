<?php
session_start();

require_once 'db_connect.php';

$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'Invalid user ID']);
    exit;
}

$stmt = $pdo->prepare('SELECT LASTNAME, FIRSTNAME, EMAIL FROM users WHERE USERID = :user_id');
$stmt->execute(['user_id' => $userId]);
$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($userInfo);
?>