<?php
//kapcsolat létrehozása
require_once("kapcsolat.php");

//method ellenőrzése
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    //SQL mondat
    $query = "SELECT kategoriak.id, kategoriak.nev
              FROM kategoriak;";
    //SQL lekérdezés futtatása
    $result = mysqli_query($conn, $query);

    //Van-e válasz
    if ($result) {
        $kategoriak=[];
        while($row = mysqli_fetch_assoc($result)){ //$row asszociatív tömb id, nev kulcsokkal (SELECT)
            $kategoriak[] = $row;
        }
        //kommunákció beállítása JSON-re
        header("Content-Type: application/json");
        echo json_encode($kategoriak);
    }
}