<?php

require_once('kapcsolat.php');

//metódus ellenőrzése
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //leellenőrizni átjöttek-e az adatok adott kulcson
    if (isset($_POST['tantargy'])) {
        //a küldött adat átvátele változóba
        $tantargy = $_POST['tantargy'];
        //létezik-e a tantárgy
        $sql = "SELECT * FROM tantargyak WHERE tantargyak.megnevezes LIKE '$tantargy';";
        $result = mysqli_query($conn, $sql); //SQL futtatása

        if (mysqli_num_rows($result) > 0) { //jött vissza sor-->létezik a tantárgy
            //kiszámoljuk a tantárgyi átlagot
            $sql = "SELECT tantargyak.megnevezes AS 'tantargy_neve', 
                           AVG(ertekelesek.jegy) AS 'atlag'
                    FROM ertekelesek, tantargyak
                    WHERE ertekelesek.tantargyid = tantargyak.id 
                          AND tantargyak.megnevezes LIKE '$tantargy';";
            $result = mysqli_query($conn, $sql); //SQL futtatása
            if (mysqli_num_rows($result) > 0) { //sikeres futtatás
                $row = mysqli_fetch_assoc($result); //$row változó tartalmazza az eredményt 'tantargy_neve' és 'atlag' (Ezt a SELECT-ben határoztuk meg)
                //válasz küldése
                http_response_code(200);
                header('Content-Type: application/json'); //a válasz JSON-be küldjük
                echo json_encode($row);
            }
        } else { //nem létezik a tantárgy (HIBA)
            //válasz küldése hiba esetén
            http_response_code(404);
            header('Content-Type: application/json'); //a válasz JSON-be küldjük
            echo json_encode(
                [
                    "error" => "A megadott tantárgy nem található az adatbázisban."
                ] //PHP asszociatív tömb, amit json_encode átalakít JSON formátumba, az echo pedig a frontendnek küld   
            );
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT tanulok.nev, tantargyak.megnevezes AS 'tantargy',
                   ertekelesek.jegy AS 'erdemjegy'
            FROM tanulok, ertekelesek, tantargyak
            WHERE tanulok.id = ertekelesek.tanuloid AND 
                  ertekelesek.tantargyid = tantargyak.id;";
    $result = mysqli_query($conn, $sql); //SQL indítása

    if (mysqli_num_rows($result) > 0) { //adott vissza sorokat a lekérdezés
        $ertekelesek = []; //ebbe kerülnek a visszaadott értékelések
        while ($row = mysqli_fetch_assoc($result)) { //$row változóba egy értékelés kerül ('nev', 'tantargy', 'erdemjegy' kulcsokon)
            $ertekelesek[] = $row;
        }
        //megvannak az értékelések, válasz küldése JSON
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($ertekelesek);
    }
}
