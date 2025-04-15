<?php

//kapcsolat létrehozása
require_once('kapcsolat.php');
//method ellenőrzés (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET'){

//sql mondat megírása
    $query = "SELECT kategoriak.id, kategoriak.nev
              FROM kategoriak;";

//lekérdezés futtatása
    $result = mysqli_query($conn, $query);
//jött-e vissza adat
    if($result){
        $kategoriak = [];
//fetch az eredményen és kategoriak tömb feltöltése
        while ($row = mysqli_fetch_assoc($result)) {
            $kategoriak[] = $row;
        }
//header
    header("Content-Type: application/json");
//eredmény JSON formétumba történő küldése
    echo json_encode($kategoriak);
    }
}