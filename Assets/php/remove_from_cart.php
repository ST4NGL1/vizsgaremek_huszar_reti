<?php
session_start();
include 'db_connection.php'; // Include your database connection file

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$userid = $_SESSION['user_id'];
$itemId = json_decode(file_get_contents('php://input'), true)['itemId'];

// Remove item from cart
$sql = "DELETE FROM cart WHERE USERID = ? AND ITEMID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $userid, $ITEMID);
$stmt->execute();

echo json_encode(['success' => true]);
?>