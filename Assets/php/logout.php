<?php

// Check for a DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Start the session
    session_start();

    // Destroy session variables
    session_unset();
    session_destroy();

    // Set response header to JSON
    header('Content-Type: application/json');
    
    // Return a JSON response indicating success
    echo json_encode(['status' => 'success', 'message' => 'Logout successful']);
    exit();
}

// If we get here, the request method is not DELETE, so we can handle the error
http_response_code(405); // Method Not Allowed
header('Content-Type: application/json');
echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
exit();
?>