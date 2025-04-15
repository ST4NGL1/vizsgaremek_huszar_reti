<?php
//backend
//olyan api-t készítünk, ami JSON formátumba visszaadja az ingatlanok összes adatát

//1. lépés: kapcsolat létrehozása
require_once("kapcsolat.php");

//2. lépés a kérés típusának ellenőrzése (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //3. lépés: SQL mondat felvétele a $query változóba (string)
    $query = "SELECT ingatlanok.id, kategoriak.id AS 'kategoriaId', kategoriak.nev AS 'nev', 
                     ingatlanok.leiras, ingatlanok.hirdetesDatuma, ingatlanok.tehermentes,
                     ingatlanok.ar, ingatlanok.kepUrl
              FROM   ingatlanok, kategoriak
              WHERE  ingatlanok.kategoria_id = kategoriak.id;";
    
    //4. lépés a lekérdezés futtatása a $conn kapcsolaton keresztül, az eredmény a $result változóba kerül
    $result = mysqli_query($conn, $query);
    //echo "<pre>";
    // var_dump($result);

    //5. lépés: Kaptunk-e választ
    if ($result) {
        $ingatlanok = [];
        while ($row = mysqli_fetch_assoc($result)) { // $row-->asszociatív tömb, amibe egy rekord adatai kerülnek
            //var_dump($row); 
            //$row egy ingatlan adatát tartalmazza asszociatív tömbként, a kulcsok a select-ben megadott attribútumok lesznek
            $ingatlanok[] = $row;
        }
        //var_dump($ingatlanok);
        header("Content-Type: application/json"); //JSON adattípussal kommunikálunk
        echo json_encode($ingatlanok);
    }
}