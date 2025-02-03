<?php
error_log("New Error ");
session_start();

// Log raw input
$rawInput = file_get_contents('php://input');
error_log("Raw input: " . $rawInput);

$data = json_decode($rawInput, true);

// Log decoded JSON
error_log("Decoded JSON: " . print_r($data, true));

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
    exit;
}

require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    // Get input values
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    // Log input values
    error_log("Email: " . $email);
    error_log("Password: " . $password);

    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Email and password are required']);
        exit;
    }

    // Fetch user by email
    $stmt = $pdo->prepare('SELECT * FROM users WHERE EMAIL = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Log fetched user data
    error_log("Fetched user: " . print_r($user, true));

    if (!$user || !password_verify($password, $user['PASSWORD'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
        exit;
    }

    // Set session variables
    $_SESSION['user_id'] = $user['USERID'];
    $_SESSION['email'] = $user['EMAIL'];
    $_SESSION['user_name'] = $user['FIRSTNAME'];
    $_SESSION['logged_in'] = true;

    // Log session variables
    error_log("Session variables: " . print_r($_SESSION, true));

    // Successful login
    $response = [
        'success' => true,
        'message' => 'Login successful',
        'logged_in' => true,
        'user_id' => $_SESSION['user_id'],
        'email' => $_SESSION['email']
    ];

    // Log response
    error_log("Response: " . json_encode($response));

    echo json_encode($response);
}
?>