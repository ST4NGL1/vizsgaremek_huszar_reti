<?php

// https://randomuser.me/api/ a link segítségével egy random user 
// sok-sok véletlenszerűen összeválogatott adathalmazához jutunk.
//amennyiben a paraméterezzük pl. https://randomuser.me/api/?results=10, 
//úgy 10 felhasználó adatát kapjuk JSON formátumban

//Feladat:
//Olvasd be agy asszociatív tömbbe 15 felhasználó adatát, a fenti linkről! 
//Jelenítsd meg egy kiválasztott felhasználó névjegykártyáját!
//Ehhez vegyél fel egy legördülő listát, amelyben jelenjenek meg 
//a user nevek (Miss Jennie Nichols),
//ha kiválasztunk egy nevet, akkor jelenjen meg az adott személy névjegykártyája az alábbi adatokkal:
    //teljes név, telefonszám, email cím, lakcím, fénykép

//Útvonalak:
//  13_F/2024_10_15/nevjegy --> névjegyadatok kezelése (főoldal)
//  13_F/2024_10_15/ --> címlap (Ugrás a főoldalra)
//  minden más esetben: 'Az oldal nem jeleníthető meg, ugrás a címlapra'