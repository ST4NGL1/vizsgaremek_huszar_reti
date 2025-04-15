<?php
//backend
//kapcsolat létrehozása
require_once('kapcsolat.php');

//GET method, visszaadja az ingatlanok összes adatát JSON formátumba
//1. lépés a method lekérdezése
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //2. lépés SQL mondat létrehozása (string)
    $query = "SELECT ingatlanok.id, kategoriak.id AS 'kategoriaId', kategoriak.nev AS 'kategoriaNev', 
                     ingatlanok.leiras, ingatlanok.hirdetesDatuma, ingatlanok.tehermentes,         
                     ingatlanok.ar, ingatlanok.kepUrl
              FROM   ingatlanok, kategoriak
              WHERE  ingatlanok.kategoria_id = kategoriak.id;";
    //3. lépés a lekérdezés futtatása
    $result = mysqli_query($conn, $query); //$result tartalma hiba esetén NULL, egyéb esetben egy object

    //4. lépés: Kaptunk-e eredményt
    if ($result) { //nem NULL a változó értéke, azaz van eredmény
        $ingatlanok = []; //asszociatív tömböket fog tartalmazni, az ingatlanok adataival

        //5. lépés kinyerjük a sorokat a $result változóból
        while($row = mysqli_fetch_assoc($result)){
            // echo "<pre>";
            // var_dump($row);
            //$row egy ingatlan adatát tartalmazza asszociatív tömbként, amelynek kulcsai a select-ben megadott attribútum nevek
            $ingatlanok[] = $row;
        }//az $ingatlanok változóba az összes ingatlan adata bekerült
        // echo "<pre>";
        // var_dump($ingatlanok);

        //6.lépés visszaadni az eredményt ($ingatlanok) JSON formátum
        //meg kell adni a visszaadott adat formátumát
        header("Content-Type: application/json");
        echo json_encode($ingatlanok); //json_encode($ingatlanok) --> a tömböt átrakta JSON-be

    }

}