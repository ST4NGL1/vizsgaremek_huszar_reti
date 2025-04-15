<?php
//kapcsolat létrehozása
require_once('kapcsolat.php');
//metódus lekérdezése (GET)
if($_SERVER["REQUEST_METHOD"] === "GET"){
    //SQL lekérdezés (kategoriak tábla minden adata kell)
    $query = "SELECT id, nev FROM kategoriak";

    //lekérdezés futtatása
    $result =  mysqli_query($conn, $query);
    //$result változó tartalmát belerakjuk egy PHP objektumokat tartalmazó tömbbe
    $kategoriak = [];
    //van-e a lekérdezésnek eredménye
    if($result){
        //végimegyünk a visszaadott eredményen $result
        while($row = mysqli_fetch_assoc($result)){ //$row változóba egy eleme kerül a $result-nak
            $kategoria = [
                'id' => $row['id'],
                'nev' => $row['nev']
            ];
            //fűzzük a $kategoriak tömb végére
            $kategoriak[] = $kategoria;
        }
        header('Content-Type: application/json');
        echo json_encode($kategoriak);
    }
    else{ //nincs eredmény--> $result értéke null
        header('Content-Type: application/json');
        echo json_encode(['uzenet' => 'Hiba az adatok lekérdezésében!']);
    }
}
?>