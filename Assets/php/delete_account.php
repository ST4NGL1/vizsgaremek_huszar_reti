<?php
session_start();
require 'db_connect.php'; // Include your database connection

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id']; // Assuming user ID is stored in session

    if ($userId) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            $response['success'] = true;
            session_destroy(); // Destroy the session after account deletion
        } else {
            $response['message'] = 'Failed to delete account.';
        }

        $stmt->close();
    } else {
        $response['message'] = 'User not logged in.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>