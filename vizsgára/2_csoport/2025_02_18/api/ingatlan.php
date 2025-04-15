<?php
//kapcsolat létrehozása a kapcsolat.php importlásával:
require_once("kapcsolat.php");

//feladat: szeretném visszakapni az ingatlanok összes adatát JSON formátumba --> metódus: GET
//$_SERVER superGlobal--> Request_Method kulcsa megadja, hogy milyen metódussal érkezett  a kérés
if($_SERVER["REQUEST_METHOD"] === "GET"){
    //adatok lekérdezésének elkészítése
    $query = "SELECT ingatlanok.id, kategoriak.nev AS kategoria, ingatlanok.leiras, 
              ingatlanok.hirdetesDatuma, ingatlanok.tehermentes, ingatlanok.ar, ingatlanok.kepUrl
              FROM kategoriak, ingatlanok WHERE kategoria_id = kategoriak.id";
    //lekérdezés futtatása--> $conn-ban lévő kapcsolaton keresztül
    $result = mysqli_query($conn, $query);

    if($result){ //van eredménye a lekérdezésnek
        //$result változó tartalmát helyezzük egy PHP objektumokat tartalmazó tömbbe
        $ingatlanok = [];
        //végig kell menni a $result elemein: $row = mysqli_fecth_assoc($result)
        //minden elemet beletesz a $row változóba, ami kulcs érték párokat tartalmaz,
        //ahol a kulcs a SELECT-ben megadott atrributumnév
        while($row = mysqli_fetch_assoc($result)){
            //$row átalakítása PHP objektummá
            
            //$ingatlanok tömbbe belehelyezni az $ingatlan tömböt
            $ingatlanok[] = $row; //tömb végére teszi az új ingatlant
        }
        header('Content-Type: application/json'); //JSON-el kommunikálunk
        echo json_encode($ingatlanok);

    }
    else{
        //echo visszaadja backend oldalról az adatokat
        //json_encode --> JSON-be konvertálja a PHP objektumot: ['uzenet' => 'Hiba az adatok lekérdezésekor']
        //kulcs => érték pár
        echo json_encode(['uzenet' => 'Hiba az adatok lekérdezésekor']);
    }
}   

//ha a kérés metódusa POST
if($_SERVER["REQUEST_METHOD"] === "POST"){
//megérkeztek-e az adatok a szerver oldalra
    if(
        isset($_POST['kategoria']) &&//létezik-e a $_POST szuperglobál 'kategoria' kúlcsú eleme; azért 'kategoria' mert a select name paramétere a kulcs
        isset($_POST['hirdetesDatuma']) &&
        isset($_POST['leiras']) &&
        isset($_POST['tehermentes']) &&
        isset($_POST['ar']) &&
        isset($_POST['kepUrl'])
    ){
        //adatok eltárolása PHP változókba
        $kategoria = $_POST['kategoria'];
        $hirdetesDatuma = $_POST['hirdetesDatuma'];
        $leiras = $_POST['leiras'];
        $tehermentes = $_POST['tehermentes'];
        $ar = $_POST['ar'];
        $kepUrl = $_POST['kepUrl'];

        //SQL mondat létrehozása a rekord beszúrására az ingatlanok táblába
        $sql = "INSERT INTO ingatlanok (kategoria_id, leiras, hirdetesDatuma, tehermentes, ar, kepUrl)
                VALUES ('$kategoria','$leiras', '$hirdetesDatuma', '$tehermentes', '$ar', '$kepUrl')";
        //if logikai vizsgálat részében futtajuk a lekérdezést, és ha sikeres volt a beszúrás akkor belemegy az if-be
        if(mysqli_query($conn, $sql)){
            //sikeres a beszúrás, a id AUTO INCREMENT, így automatikusan bekerült
            //dobjuk vissza az id-t a kliens oldalra
            $ujId = mysqli_insert_id($conn); //megkapjuk a beszúrt rekord id-jét
            //http_response_code(201); //válasz státusza --> OK
            header('Content-Type: application/json'); //JSON-el kommunikálunk
            echo json_encode(['id' => $ujId]); //üzenet kilens felé egy id kulcsra az ujId értékét helyeztük, jsonné alakítva 
        }
        else{ //nem sikerül az adatok beillesztése
            //http_response_code(400);
            header('Content-Type: application/json'); //JSON-el kommunikálunk
            echo json_encode(['uzenet' => 'Sikertelen beszúrás']);
        }
    }
}
if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
if(isset($_GET['id'])){ //átjött-e az adat; Az id kulcsot az input mező name paramétere miatt kapta
    //adat átvétele
    $id = $_GET['id'];
    //kell egy lekérdezés ami alapján el tudjuk dönteni, hogy létezik-e ilyen id-vel rekord
    $sql = "SELECT * FROM ingatlanok WHERE id='$id' ";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){ //ha a visszaadott sorok száma nagyobb nulla
        //volt ilyen id
        $sql = "DELETE FROM ingatlanok WHERE id='$id'";
        if(mysqli_query($conn, $sql)){
            //sikeres törlés
            echo "Az ingatlan törölve";
        }
        else{
            echo "törlés sikertelen";
        }
    }
}
}

?>