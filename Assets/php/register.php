<?php
header('Content-Type: application/json');
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $lastname = $data['lastname'] ?? '';
    $firstname = $data['firstname'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    if (empty($lastname) || empty($firstname)|| empty($email) || empty($password)) {
        echo json_encode(['error' => 'Minden mező kitöltése kötelező']);
        exit;
    }

   
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['error' => 'Ez az email cím már használatban van']);
        exit;
    }

   
    $stmt = $pdo->prepare('INSERT INTO users (lastname,firstname, email, password) VALUES (:lastname,:firstname, :email, :password)');
    $stmt->execute([
        'lastname' => $lastname,
        'firstname'=>$firstname,
        'email' => $email,
        'password' => $hashed_password
    ]);

    echo json_encode(['message' => 'Sikeres regisztráció']);
}
?>