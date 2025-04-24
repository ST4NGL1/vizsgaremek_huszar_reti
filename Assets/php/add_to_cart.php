<?php
session_start();

$data = json_decode(file_get_contents('php://input'), true);
$itemId = $data['itemId'] ?? null;

if (!$itemId) {
    echo json_encode(['success' => false, 'message' => 'Invalid item ID']);
    exit;
}

require_once 'db_connect.php';

$stmt = $pdo->prepare('INSERT INTO cart (ITEMID, USERID) VALUES (:item_id, :user_id)');
$stmt->execute(['user_id' => $_SESSION['user_id'], 'item_id' => $itemId]);

echo json_encode(['success' => true, 'message' => 'Sikeresen hozzáadva a kosárhoz']);
?>