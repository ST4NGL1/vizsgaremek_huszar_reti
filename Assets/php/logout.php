<?php

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    
    session_start();

    
    session_unset();
    session_destroy();

    header('Content-Type: application/json');
    
    
    echo json_encode(['status' => 'success', 'message' => 'Sikeres kijelentkezés']);
    exit();
}


http_response_code(405); 
header('Content-Type: application/json');
echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
exit();
?>