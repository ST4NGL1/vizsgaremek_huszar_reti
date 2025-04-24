<?php
session_start();
include 'db_connect.php';;

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Felhasználó nincs bejelentkezve']);
    exit();
}

$userId = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);

$lastname = $data['Lastname'];
$firstname = $data['Firstname'];
$email = $data['Email'];

try {
    $stmt = $pdo->prepare("UPDATE users SET LASTNAME = ?, FIRSTNAME = ?, EMAIL = ? WHERE USERID = ?");
    $stmt->execute([$lastname, $firstname, $email, $userId]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>