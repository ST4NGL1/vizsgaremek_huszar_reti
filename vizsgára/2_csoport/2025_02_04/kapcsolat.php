<?php
//adatbázis kapcsolat létrehozása
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "ingatlan";

 //kapcsolat létrehozása, az adatbázison végrehajtott műveletek a $conn változón keresztül történnek
 $conn = mysqli_connect($servername, $username, $password, $dbname);

 //létrejött-e a kapcsolat?
 if (!$conn) {  //ha nem jött létre a kapcsolat
    die("A kapcsolat nem jött létre" . mysqli_connect_error()); //mysqli_connect_error() --> milyen hiba történt
 }

