<?php
session_start();

require_once 'db_connect.php';

$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'Invalid user ID']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$lastname = $data['Lastname'] ?? '';
$firstname = $data['Firstname'] ?? '';
$email = $data['Email'] ?? '';
$phone = $data['Phone'] ?? '';

$stmt = $pdo->prepare('UPDATE users SET LASTNAME = :lastname, FIRSTNAME = :firstname, EMAIL = :email, WHERE id = :user_id');
$success = $stmt->execute([
    'lastname' => $lastname,
    'firstname' => $firstname,
    'email' => $email,
    'user_id' => $userId
]);

if ($success) {
    echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
}
?>