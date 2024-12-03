<?php
header("Content-Type: application/json");

// Include your database connection (make sure to replace the placeholder with actual connection details)
include('db_connection.php');  // assuming you have a separate file for DB connection

// Get POST data from the request
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['email']) && isset($data['password'])) {
    $email = $data['email'];
    $password = $data['password'];

    // Check if user exists in the database
    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
w
    if ($result->num_rows > 0) {
        // User exists, get the stored hashed password
        $user = $result->fetch_assoc();
        $storedHashedPassword = $user['password'];
        $username = $user['firstname']; // Assuming 'username' field exists in your 'users' table

        // Verify the provided password with the stored hash
        if (password_verify($password, $storedHashedPassword)) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Login successful',
                'data' => [
                    'username' => $username // Send username in response
                ]
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid username or password'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'User not found'
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Email and password are required'
    ]);
}

$conn->close();
?>
