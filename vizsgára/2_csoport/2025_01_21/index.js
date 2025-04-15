//frontend, feladata az ingatlanok.php által szolgáltatott adatok feldolgozása, 
//táblázatba helyezése

function ingatlanok_adatai(){
    fetch("ingatlanok.php")
        .then(adat => adat.json())
        .then(ingatlanok => { //ingatlanok változó minden ingatlan adatát tartalmazza
            //console.log(ingatlanok);
            //rámutatunk a helyre, ahova az ingatlanok adatait szeretnénk betenni
            hely = document.getElementById("ingatlanok");
            ingatlanok.forEach(ingatlan => {
                //létrehozunk a sor változóba egy HTML tr elemet: sor--> <tr></tr>
                sor = document.createElement('tr');
                //A tr elem HTML kódját írjuk, azaz beleteszünk 7 db td-t a megfelelő adatokkal
                sor.innerHTML = `
                    <td>${ingatlan.id}</td>
                    <td>${ingatlan.nev}</td>
                    <td>${ingatlan.leiras}</td>
                    <td>${ingatlan.hirdetesDatuma}</td>
                    <td>${ingatlan.tehermentes === "1" ? "Igen" : "Nem"}</td>
                    <td>${ingatlan.ar}</td>
                    <td><img src="${ingatlan.kepUrl}"></td>
                `; //elkészült egy sor
                //berakni a táblázat tbody részébe
                hely.appendChild(sor);
            })
        })
} 
function kategoriak_adatai(){
    fetch('kategoriak.php')
        .then(adat => adat.json())
        .then(kategoriak => {
            console.log(kategoriak);
            hely = document.getElementById("kategoriak")
            kategoriak.forEach(kategoria => {
                opcio = document.createElement('option')
                opcio.value = kategoria.id
                opcio.textContent = kategoria.nev
                hely.appendChild(opcio)
            })
        })
}
//függvény hívása
ingatlanok_adatai();
kategoriak_adatai();