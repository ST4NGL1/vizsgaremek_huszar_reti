<?php
$host = 'localhost';
$dbname = 'restaurant_project';  // Your database name
$username = 'root';           // Your MySQL username
$password = '';               // Your MySQL password

// Create a new PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Set error mode
   // echo "Sikeres közösülés az adatbázissal! :)"; 
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
