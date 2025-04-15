function lekerdezes(){
    fetch('/13_G/2024_12_04/ingatlan')
        .then(adat => adat.json())
        .then(adat => {
            //mutassunk rá a tbody-ra
            const hely = document.getElementById("ingatlanok");
            hely.innerHTML = ""; //ha volt HTML kód a tbody-ban, akkor törli
            adat.forEach(ingatlan => { //ingatlan változóba egy objektum kerül, ami kulcs-érték párokból épül fel
                const sor = document.createElement('tr'); //tr-taget hoz létre
                //mivel a sor változó HTML tag, így tudjuk innerHTML-el írni a tartalmát, belerakunk 7 db td-t
                //az ingatlan változó id kulcsú eleme: ${ingatlan.id}
                sor.innerHTML = `
                    <td>${ingatlan.id}</td> 
                    <td>${ingatlan.kategoria}</td> 
                    <td>${ingatlan.leiras}</td> 
                    <td>${ingatlan.hirdetesDatuma}</td> 
                    <td>${ingatlan.tehermentes == 1 ? "igen": "nem"}</td> 
                    <td>${ingatlan.ar}</td> 
                    <td><img src = "${ingatlan.kepUrl}" alt = "ingatlan képe"></td> 
                `;
                //tbody-hoz hozzáteszünk egy tr gyereket
                hely.appendChild(sor);
            });
        })
}

lekerdezes();