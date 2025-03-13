<?php
session_start();
require_once 'db_connect.php'; // Adjust path as needed

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['USERID'])) {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit;
}

$userId = $_SESSION['USERID'];
$input = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($input['itemId'])) {
    $itemId = intval($input['itemId']);
    
    $stmt = $conn->prepare("INSERT INTO cart (ITEMID, USERID) VALUES (?, ?)");
    $stmt->bind_param("ii", $itemId, $userId);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error"]);
    }
    $stmt->close();
    exit;
}

// Retrieve cart items
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare("SELECT menu.id, menu.name, menu.price FROM cart JOIN menu ON cart.ITEMID = menu.id WHERE cart.USERID = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $cartItems = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($cartItems);
    exit;
}

// Invalid request
echo json_encode(["success" => false, "message" => "Invalid request"]);
exit;
