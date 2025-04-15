<?php
    //request során érkező query paraméterek a $_GET szuperGlobal változóba kerülnek,
    //ami kulcs=>érték párokat tartalmaz
    // $_GET[ //ez csak szemléltés
    //     "mennyit"=>"15",
    //     "mirol"=>"USD",
    //     "mire"=>"HUF"
    // ]

    echo "<pre>"; //struktúrális kiírás miatt kell
    //var_dump($_GET);
    //$_GET["mennyit"] --> adott kulcsú elem nem létezik (isset), akkor alapértelmezett értéket kap a változó
    //$mennyit = isset($_GET["mennyit"]) ? $_GET["mennyit"] : 1;
    //röviden:
    $mennyit = (int)($_GET["mennyit"] ?? 1); //?? után a false érték van, ?? előtt az igaz, ha a változó létezik
    $mirol = $_GET["mirol"] ?? "USD";
    $mire = $_GET["mire"] ?? "HUF";
    //var_dump($mennyit, $mirol, $mire); //ellenőrzés típusra és értékre egyaránt FONTOS!!!

    //adatokátvétele a szerverről:
    //$adatok string típusú, mivel a szerverről adazok JSON-be jönnek át
    $adatok = file_get_contents("https://kodbazis.hu/api/exchangerates?base=".$mirol);
    //var_dump($adatok); //"{"rates":{"HUF":307.07,"RUB":76.44,"USD":1,"EUR":0.85},"base":"USD"}"

    //$adatok string átalakítása asszociatív tömmbbé
    // $atalakitott_adat = [
    //     "rates"=>[
    //       "HUF"=>307.07,
    //       "RUB"=>76.44,
    //       "USD"=>1,
    //       "EUR"=>0.85
    //     ],
    //     "base"=>"USD"
    // ];
    $atalakitott_adat = json_decode($adatok, true); //true miatt lesz asszociatív tömb, ha ez elmarad akkor object típus lesz
    //var_dump($atalakitott_adat);

    //meghatározza az átváltás eredményét
    $eredmeny = $mennyit * $atalakitott_adat["rates"][$mire];
    //echo $eredmeny;

    //./ --> relatív hivatkozás, az aktív könyvtárból indulunk
    $select_adatok = json_decode(file_get_contents("./currencies.json"),true);
    // $select_adatok = [
    //     [
    //         "name"=>"USA Dollár",
    //         "symbol"=>"$",
    //         "label"=>"USD",
    //     ],
    //     [
    //         "name"=>"Magyar Forint",
    //         "symbol"=>"Ft",
    //         "label"=>"HUF"
    //     ],
    //     [
    //         "name"=>"Euró",
    //         "symbol"=>"€",
    //         "label"=>"EUR"
    //     ],
    //     [
    //         "name"=>"Orosz Rubel",
    //         "symbol"=>"₽",
    //         "label"=>"RUB"
            
    //     ]
    // ];
    //var_dump($select_adatok);
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" />
</head>

<body>
    <div class="card w-25 m-auto p-3">
        <form action="./index.php" method="GET">
            <h4>Mennyit:</h4>
            <input class="form-control mb-2" type="number" name="mennyit" value="<?php echo $mennyit ?>">
            <h4>Miről?</h4>
            <select name="mirol" class="form-control mb-2">
                <?php foreach($select_adatok as $adat): //$adat változóba egy asszociatív tömb került?>
                    <option value="<?php echo $adat["label"] //itt kell megjeleníteni $adat változó label kulcsú elemét?>" <?php echo $adat["label"] === $mirol ? "selected" : "" ?> >
                        <?php echo $adat["name"]." ".$adat["symbol"] //itt kell megjeleníteni $adat változó name és symbol kulcsú elemének összefűzését?>
                    </option>
                <?php endforeach?>
            </select>
            <?php echo $eredmeny ?>
            <h4>Mire?</h4>
            <select name="mire" class="form-control mb-2">
                <?php foreach($select_adatok as $adat): //$adat változóba egy asszociatív tömb került?>
                    <option value="<?php echo $adat["label"] //itt kell megjeleníteni $adat változó label kulcsú elemét?>" <?php echo $adat["label"] === $mire ? "selected" : "" ?> >
                        <?php echo $adat["name"]." ".$adat["symbol"] //itt kell megjeleníteni $adat változó name és symbol kulcsú elemének összefűzését?>
                    </option>
                <?php endforeach?>
            </select>

            <input type="submit" value="Elküld">

            
        </form>
    </div>
</body>

</html>

