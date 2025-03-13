<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['USERID'])) {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit;
}

$userId = $_SESSION['USERID'];
$input = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($input['itemId'])) {
    $itemId = intval($input['itemId']);
    
    $stmt = $conn->prepare("DELETE FROM cart WHERE ITEMID = ? AND USERID = ? LIMIT 1");
    $stmt->bind_param("ii", $itemId, $userId);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error"]);
    }
    $stmt->close();
    exit;
}

echo json_encode(["success" => false, "message" => "Invalid request"]);
exit;
