<?php

require_once('kapcsolat.php');

if($_SERVER['REQUEST_METHOD']==='GET'){
    $sql = "SELECT *
            FROM tanulok";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) { 
        $tanulok=[];
        while($row = mysqli_fetch_assoc($result)) {
            $tanulok[]=$row;
        }
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($tanulok);
    }
}
elseif($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['tantargy'])){
        $tantargy = $_POST['tantargy'];

        $sql = "SELECT * 
                FROM tantargyak
                WHERE tantargyak.megnevezes LIKE '$tantargy';";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $sql = "SELECT tanulok.nev AS 'tanulo_nev', AVG(ertekelesek.jegy) AS 'atlag'
                    FROM tanulok,tantargyak, ertekelesek
                    WHERE tanulok.id = ertekelesek.tanuloid AND ertekelesek.tantargyid = tantargyak.id AND tantargyak.megnevezes LIKE '$tantargy'
                    GROUP BY tanulok.id;";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                $atlagok = [];
                while($row = mysqli_fetch_assoc($result)) {
                $atlagok[]=$row;
                }
                http_response_code(200);
                header('Content-Type: application/json');
                echo json_encode($atlagok);
            }
            else {
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode(["error"=>"A $tantargy tantárgyból még nincsenek értékelések."]);
            }
            
        } 
        else {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(["error"=>"A megadott e-mail cím vagy telefonszám már létezik"]);
        }

    }
    
    
}
