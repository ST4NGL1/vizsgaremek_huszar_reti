<?php
//útvonalválasztó (végpontok meghatározása)
$path = parse_url($_SERVER['REQUEST_URI'])['path']; //utvonal
//var_dump($path);  //"/13_G/2024_12_04/"
//var_dump(parse_url($_SERVER['REQUEST_URI'])); // ["query"]=> string(4) "id=1"

$query =  parse_url($_SERVER['REQUEST_URI'])['query'] ?? "";   //vagy üres string, vagy a paraméter (id=1)
//URL:
//   /13_G/2024_12_04/ --> ingatlanok.html
//   /13_G/2024_12_04/feladas  --> feladas.html
//   /13_G/2024_12_04/torles --> torles.html
//ITT TARTUNK
//végpontok
//   /13_G/2024_12_04/ingatlan --> ingatlan.php
//  /13_G/2024_12_04/kategoria --> kategoria.php
switch ($path) {
    case '/13_G/2024_12_04/':
        require_once('./views/ingatlanok.html');
        break;
    case '/13_G/2024_12_04/feladas':
        require_once('./views/feladas.html');
        break;
    case '/13_G/2024_12_04/torles':
        require_once('./views/torles.html');
        break;
    case '/13_G/2024_12_04/ingatlan':
        require_once('./api/ingatlan.php');
        break;
    case '/13_G/2024_12_04/kategoria':
        require_once('./api/kategoria.php');
        break;
    default:
        echo "Az oldal nem található! <a href='/13_G/2024_12_04/'>Ugrás a főoldalra</a>";
        break;
}