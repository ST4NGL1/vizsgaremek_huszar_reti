<?php
    //echo "Hello";
    //készíts függvényt, amely bemenő paraméteréről eldönti, hogy páros vagy páratlan-e
    //visszatérési értéke: "páros" / "páratlan"
    function paros_e($szam){ //egy paraméteres függvény, paraméter a függvényre nézve lokális változó
        return $szam % 2 == 0 ? "páros" : "páratlan";
    }
    //függvény hívása, kiiratás
    echo paros_e(12)."<br>";

    //készíts függvényt, amely két bemenő paramétere közül visszatér a nagyobb értékével
    function nagyobb($szam1, $szam2){ //két paraméteres függvény
        return $szam1 > $szam2 ? $szam1 : $szam2;
    }
    //függvény hívása, kiiratás
    $sz1 = 12;
    $sz2 = 4;
    echo "A $sz1 és $sz2 számok közül a nagyobb: ".nagyobb($sz1, $sz2)."<br>";
    //tömbök
    //indexelt tömb
    $szamok1 = array(12,34,56,-12,23);
    $szamok2 = [12,56,77,-98,34];
    var_dump($szamok1);
    echo "<br>A legkisebb szám a tömbben: ".min($szamok1)."<br>";
    sort($szamok1); //növekvő sorrendbe rendez
    //tömb elemeinek kiiratása
    foreach ($szamok1 as $value) {//$value változóba kerülnek az elemek egyesével
        echo $value." ";
    }
    //tömb elemszáma
    echo "<br>A tömb elemszáma: ".count($szamok1)."<br>";
    //asszociatív tömb: kulcs => érték párokat tartalmaz
    $ingatlan = [
        "id" => 1,
        "leiras" => "családi ház",
        "ar" => 30000000,
        "hirdetesDatuma" => "2024_02_03",
        "tehermentes" => true
    ];
    //ingatalan árának kiiratása (a kulccsal indexelek)
    echo "Az ingatlan ára: ".$ingatlan["ar"]."<br>";
    //Az $ingatlan tömb összes adatának kiiratása:
    echo "<br>Az ingatlan összes adata:<br>";
    foreach ($ingatlan as $key => $value) {
       echo $key.": ".$value."<br>";
    }
    //több ingatlan adatainak eltárolása:
    $ingatlanok = [
        [ //$ingatlanok 0. eleme --> asszociatív tömb
            "id" => 1,
            "leiras" => "családi ház",
            "ar" => 30000000,
            "hirdetesDatuma" => "2024_02_03",
            "tehermentes" => true
        ],
        [
            "id" => 2,
            "leiras" => "családi ház",
            "ar" => 35000000,
            "hirdetesDatuma" => "2024_02_20",
            "tehermentes" => false
        ],
        [
            "id" => 3,
            "leiras" => "garázs",
            "ar" => 3000000,
            "hirdetesDatuma" => "2024_05_03",
            "tehermentes" => true
        ],
        [
            "id" => 4,
            "leiras" => "zárt kert",
            "ar" => 7000000,
            "hirdetesDatuma" => "2024_06_03",
            "tehermentes" => true
        ]
    ];
    //első ingatlan hirdetésének dátuma:
    echo "<br>Feladás dátuma: ".$ingatlanok[0]["hirdetesDatuma"]."<br>";
    //jelenítsük meg a 40000000 alatti családi házak összes adatát
    echo "<h1>40000000 Ft alatti családi házak adatai:</h1>";
    foreach ($ingatlanok as $value) { //$value tartalma mindig egy darab asszociatív tömb
        if ($value["ar"] < 40000000 && $value["leiras"]=== "családi ház") {
            echo "Azonositó: ".$value["id"]."<br>Ár: ".$value["ar"]."<br>Típus: ".$value["leiras"]."<br>Hirdetés dátuma: ".$value["hirdetesDatuma"]."<br>Tehermentes?: ".($value["tehermentes"] ? "igen" : "nem")."<br><br>";
        }
    }

    echo "<h1>40000000 Ft alatti családi házak adatai:</h1>";
    foreach ($ingatlanok as $value) { //$value tartalma mindig egy darab asszociatív tömb
        if ($value["ar"] < 40000000 && $value["leiras"]=== "családi ház") {
           //$value egy asszociatív tömb amin foreach végig tud menni:
            foreach ($value as $key => $v) { //minden kulcs => érték pár belekerül a $key illetve $v változókba
                echo $key.": ".$v."<br>";
            }
        }
    }
    echo "<br><br><br>JSON:";
    echo json_encode($ingatlanok);
?>