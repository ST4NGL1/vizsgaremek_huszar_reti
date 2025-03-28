<?php
session_start();
include 'db_connect.php'; // Ensure this file is correctly named and included

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$userId = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT LASTNAME, FIRSTNAME, EMAIL FROM users WHERE USERID = ?");
    $stmt->execute([$userId]);
    $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($userInfo);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>