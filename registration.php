<?php
header("Content-Type: application/json");
include_once 'connection.php';  // Include the database connection

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input data from JSON body
    $data = json_decode(file_get_contents("php://input"));

    // Validate the data
    if (!isset($data->firstname) || !isset($data->lastname) || !isset($data->email) || !isset($data->zipcode) || !isset($data->city) || !isset($data->address) || !isset($data->password)) {
        echo json_encode(['message' => 'Hiányzó adatok!']);
        http_response_code(400);  // Bad Request
        exit;
    }

    // Sanitize user input
    $firstname = htmlspecialchars(trim($data->firstname));
    $lastname = htmlspecialchars(trim($data->lastname));
    $email = filter_var(trim($data->email), FILTER_SANITIZE_EMAIL);  // Sanitize email
    $zipcode = htmlspecialchars(trim($data->zipcode));
    $city = htmlspecialchars(trim($data->city));
    $address = htmlspecialchars(trim($data->address));
    $password = trim($data->password);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['message' => 'Érvénytelen e-mail cím!']);
        http_response_code(400);  // Bad Request
        exit;
    }

    // Check if the password meets minimum requirements (e.g., 8 characters)
    if (strlen($password) < 8) {
        echo json_encode(['message' => 'A jelszó minimum 8 karakter hosszú kell legyen!']);
        http_response_code(400);  // Bad Request
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email already exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['message' => 'A felhasználó már létezik!']);
        http_response_code(400);  // Bad Request
        exit;
    }

    // Insert the new user into the database
    $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, email, zipcode, city, address, password) VALUES (:firstname, :lastname, :email, :zipcode, :city, :address, :password)");
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':zipcode', $zipcode);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':password', $hashed_password);

    if ($stmt->execute()) {
        $userId = $pdo->lastInsertId();  // Get the last inserted user ID
        echo json_encode(['message' => 'Sikeres regisztráció!', 'userId' => $userId]);
        http_response_code(201);  // Created
    } else {
        echo json_encode(['message' => 'Hiba történt a regisztráció közben!']);
        http_response_code(500);  // Internal Server Error
    }
}
?>
