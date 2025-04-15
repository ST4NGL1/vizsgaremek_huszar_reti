<?php

require_once('kapcsolat.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //beérkező adatok ellenőrzése (léteznek- e akulcsok a $_POST-ban)
    if (isset($_POST['tantargy'], $_POST['tanuloId'], $_POST['jegy'])) { //átjöttek az adatok
        //adatok átvétele változókba
        $tantargy = $_POST['tantargy'];
        $tanuloId = $_POST['tanuloId'];
        $jegy = $_POST['jegy'];

        //tantargy létezik-e
        $sql = "SELECT tantargyak.id FROM tantargyak WHERE tantargyak.megnevezes LIKE '$tantargy';";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) { //jött vissza sor, azaz létezik a tantárgy
            while ($row = mysqli_fetch_assoc($result)) { //most csak egyszer fut le, mert $result egy sor van
                $tantargyId = $row['id']; //létezik a tantárgy, megjegyeztük az azonosítóját, mert ez kell a beszúráshoz
            }

            //tanuló létezik-e
            $sql = "SELECT tanulok.nev, tanulok.email FROM tanulok WHERE tanulok.id = '$tanuloId';";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) { //létezik a tanuló
                while ($row = mysqli_fetch_assoc($result)) { //most csak egyszer fut le, mert $result egy sor van
                    $nev = $row['nev'];
                    $email = $row['email'];
                }
                //nincs hiba, minden ellenőrzés pozitív eredményt adott => jöhet az értékelés beszúrása
                $sql = "INSERT INTO `ertekelesek` (`tanuloid`, `tantargyid`, `jegy`)
                        VALUES('$tanuloId', '$tantargyId', '$jegy')";
                if (mysqli_query($conn, $sql)) { //sikeres beszúrás

                    $valasz = [
                        "message" => "Sikeresen hozzáadtuk az értékelést az adatbázishoz.",
                        "tanulo" => [
                            "nev" => $nev,
                            "email" => $email,
                            "tantargy" => $tantargy,
                            "jegy" => $jegy
                        ]
                    ];

                    http_response_code(200);
                    header('Conten-Type: application/json');
                    echo json_encode($valasz);
                } else { //sikertelen beszúrás (HIBA)
                    http_response_code(404);
                    header('Content-Type: application/json');
                    echo json_encode(
                        [
                            "error" => "Nem sikerült felvenni az értékelést az adatbázisba!"
                        ]
                    );
                }
            } else { //nem létezik a tanuló (HIBA)
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode(
                    [
                        "error" => "A megadott tanuló nem létezik."
                    ]
                );
            }
        } else { //nem létezik a tantárgy (HIBA)
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(
                [
                    "error" => "A megadott tantárgy nem létezik."
                ]
            );
        }
    } else { //hiányzó adat (HIBA)
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(
            [
                "error" => "Hiányzó kulcs (tantargy, tanuloId, jegy)."
            ]
        );
    }
}
