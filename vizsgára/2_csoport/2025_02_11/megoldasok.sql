1 
CREATE DATABASE TorpeTarna
DEFAULT CHARACTER SET utf8
COLLATE utf8_hungatian_ci

3.
ALTER TABLE kihol ADD FOREIGN KEY (torpe_id) REFERENCES torpek(id);
ALTER TABLE kihol ADD FOREIGN KEY (tarna_id) REFERENCES tarnak(id);
ALTER TABLE tarnak ADD FOREIGN KEY (kozet_id) REFERENCES kozetek(id);

4.
SELECT torpek.nev
FROM torpek
ORDER by torpek.magassag DESC
LIMIT 1

5.
SELECT COUNT(*)
FROM kihol, tarnak
WHERE kihol.tarna_id = tarnak.id and tarnak.nev LIKE "Gir Lodur"

6.
SELECT tarnak.nev, sum(kihol.kitermelt_mennyiseg)
FROM kihol, tarnak, kozetek
WHERE kihol.tarna_id = tarnak.id AND tarnak.kozet_id = kozetek.id AND kozetek.nev LIKE "arany"
GROUP by tarnak.nev
ORDER BY 2 DESC

7.
SELECT torpek.nev
FROM torpek, kihol
WHERE torpek.id = kihol.torpe_id AND torpek.klan LIKE "Vasököl" AND torpek.nem LIKE "N"
GROUP by torpek.nev
ORDER by sum(kihol.kitermelt_mennyiseg) DESC
LIMIT 1

8.
INSERT INTO torpek (nev, klan, nem, suly, magassag) VALUES
    ('Trad Morf', 'Vasököl', 'F', '69', '136')


Saját feladatok
8.
Ki bányászta a legkevesebb aranyat?
SELECT torpek.nev
FROM torpek, kihol, tarnak, kozetek
WHERE torpek.id = kihol.torpe_id and kihol.tarna_id = tarnak.id and tarnak.kozet_id = kozetek.id AND kozetek.nev LIKE "arany"
GROUP by torpek.nev
ORDER BY sum(kihol.kitermelt_mennyiseg) ASC
LIMIT 1;

9.
Kik azok a törpék akik 100 kg felett bányásztak?
SELECT torpek.nev
FROM torpek, kihol
WHERE torpek.id = kihol.torpe_id
GROUP BY torpek.nev
HAVING SUM(kihol.kitermelt_mennyiseg) > 100

10.
Kik azok a törpék, akik Bombur Nori kevesebbet bányásztak?
SELECT torpek.nev
FROM torpek, kihol
WHERE torpek.id = kihol.torpe_id
GROUP BY torpek.nev
HAVING SUM(kihol.kitermelt_mennyiseg) < (SELECT SUM(kihol.kitermelt_mennyiseg) 
                                         FROM torpek, kihol 
                                         WHERE torpek.id = kihol.torpe_id AND torpek.nev LIKE "Bombur Nori")

11.
Melyik az a kőzet, amiből többet termeltek, mint vasból?