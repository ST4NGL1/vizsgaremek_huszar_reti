<?php
session_start();
require 'db_connect.php';

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id']; 

    if ($userId) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            $response['success'] = true;
            session_destroy(); 
        } else {
            $response['message'] = 'Hiba a fiók törlésekor.';
        }

        $stmt->close();
    } else {
        $response['message'] = 'Felhasználó nincs bejelentkezve.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>