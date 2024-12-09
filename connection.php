<?php
//Az adatbázis kapcsolódáshoz szükséges adatok eltárolása változókban
$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "restaurant_project";

//Kapcsolódás létrehozása
$conn = new mysqli($servername, $username, $password, $dbname);

// Kapcsolat vizsgálása
if ($conn->connect_error) {
    die("Sikertelen kapcsolódás az adatbázishoz!: " . $conn->connect_error);
}
?>
