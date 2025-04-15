CREATE DATABASE ingatlan
DEFAULT CHARACTER SET utf8
COLLATE utf8_hungarian_ci;

SELECT ingatlanok.id, kategoriak.nev AS 'kategoria', ingatlanok.leiras, ingatlanok.hirdetesDatuma, ingatlanok.tehermentes, ingatlanok.ar, ingatlanok.kepUrl
FROM ingatlanok, kategoriak
WHERE kategoriak.id = ingatlanok.kategoria_id;