<?php

require_once('kapcsolat.php');

if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['nev'],$_POST['telefonszam'],$_POST['szuletesiido'],$_POST['email'])){
        $nev= $_POST['nev'];
        $telefonszam= $_POST['telefonszam'];
        $szuletesiido= $_POST['szuletesiido'];
        $email= $_POST['email'];
        
        $sql = "SELECT *
                FROM tanulok
                WHERE tanulok.telefonszam LIKE '$telefonszam' OR tanulok.email LIKE '$email';";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) == 0) {
            $sql = "";
            
            if (mysqli_query($conn, $sql)) {
              $valasz = [
                "message"=> "Sikeresen hozzáadtuk a tanulót az adatbázishoz.",
                "tanulo"=>   [
                    "nev"=> "Kovács Péter",
                    "telefonszam"=> "06201234567",
                    "szuletesiido"=> "2005-06-15",
                    "email"=> "kovacs.peter@example.com"
                ]
                ];
                http_response_code(200);
                header('Content-Type: application/json');
                echo json_encode($valasz);
            }
            else {
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode(["error"=>"Nem sikerült felvenni a tanulót az adatbázisba."]);
            }          
        } else {
          
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(["error"=>"Megadott e-mail cim vagy telefonszám már létezik."]);
        }
    }
    else{
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(["error"=>"Minden mezőt ki kell tölteni(nev, telefonszam, szuletesiido, email)."]);
    }
}