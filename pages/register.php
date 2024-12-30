<?php
include '../database/db_connect.php';

$response = [
    "success" => false,
    "message" => ""
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lastname = $_POST['Lastname'];
    $firstname = $_POST['Firstname'];
    $email = $_POST['Email'];
    $zipcode = $_POST['Zipcode'];
    $city = $_POST['City'];
    $address = $_POST['Address'];
    $password = $_POST['password'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["message"] = "Invalid email format";
        echo json_encode($response);
        exit;
    }

    // Hash the password
   // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $checkEmailStmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $checkEmailStmt->store_result();

    if ($checkEmailStmt->num_rows > 0) {
        $response["message"] = "Email ID already exists";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (lastname,firstname,email,zipcode,city,address,password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $lastname,$firstname,$email,$zipcode,$city,$address, $password);

        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "Account created successfully";
        } else {
            $response["message"] = "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $checkEmailStmt->close();
    $conn->close();
}

echo json_encode($response);
?>