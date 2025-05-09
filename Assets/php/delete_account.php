<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

session_start();
require 'db_connect.php';

$response = array('success' => false, 'message' => '');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_SESSION['user_id'])) {
            $response['message'] = 'Felhasználó nincs bejelentkezve.';
        } else {
            $userId = $_SESSION['user_id'];
            
            $stmt = $conn->prepare("DELETE FROM users WHERE USERID = ?");
            $stmt->bind_param("i", $userId);
            
            if ($stmt->execute()) {
                $response['success'] = true;
                session_destroy();
            } else {
                $response['message'] = 'Hiba a fiók törlésekor: ' . $conn->error;
            }
            
            $stmt->close();
        }
    } else {
        $response['message'] = 'Invalid request method.';
    }
} catch (Exception $e) {
    $response['message'] = 'Exception: ' . $e->getMessage();
}


header('Content-Type: application/json');
echo json_encode($response);
exit;
?>