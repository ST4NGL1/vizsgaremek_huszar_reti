<?php
// filepath: c:\xampp\htdocs\vizsga\vizsgaremek_huszar_reti\Assets\php\logout.php
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Return success response
header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'message' => 'Sikeres kijelentkezés.']);
exit;
?>