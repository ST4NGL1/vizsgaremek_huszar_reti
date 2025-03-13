<?php
session_start();
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'DELETE': // Logout
        session_destroy();
        echo json_encode(["success" => true, "message" => "Logged out successfully"]);
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(["success" => false, "message" => "Method not allowed"]);
        break;
}
?>
