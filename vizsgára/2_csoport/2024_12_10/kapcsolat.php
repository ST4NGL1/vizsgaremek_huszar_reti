<?php
//kapcsolódás az adatbázishoz
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ingatlan";

//kapcsolat létrehozása
$conn = mysqli_connect($servername, $username, $password, $dbname);

//ha nem jött létre a kapcsolat
if (!$conn) {
    die("A kapcsolat nem jött létre: ". mysqli_connect_error()); //mysqli_connect_error()--> a hiba oka
}