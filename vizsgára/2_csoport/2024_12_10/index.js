//frontend
function ingatlanokAdatai(id){
    fetch('ingatlanok.php')
        .then(adat => adat.json())
        .then(ingatlanok => {
            console.log(ingatlanok);
            //rámutatok a helyre, ahova az adatok kerülnek
            hely = document.getElementById('ingatlanok');
            hely.innerHTML = ""
            ingatlanok.forEach(ingatlan => {
                if(id === "" || id === ingatlan.kategoriaId){
                //sorokat szúrunk be a tbody-ba
                //felveszünk egy tr HTML elemet
                sor = document.createElement('tr'); //sor --> <tr></tr>
                //írjuk a tr tag tartalmat (7 db td)
                sor.innerHTML = `
                    <td>${ingatlan.id}</td>
                    <td>${ingatlan.kategoriaNev}</td>
                    <td>${ingatlan.leiras}</td>
                    <td>${ingatlan.hirdetesDatuma}</td>
                    <td>${ingatlan.tehermentes === "1" ? "igen" :"nem"}</td>
                    <td>${ingatlan.ar}</td>
                    <td><img src='${ingatlan.kepUrl}'></td>
                `; //létrejön  egy sor, amit bele kell tennem a tbody-ba
                hely.appendChild(sor);
                }
            })
        })
}
function kategoriakAdatai(id){ //id paraméterben lesz a hely id-je
    fetch('kategoriak.php')
        .then(adat => adat.json())
        .then(kategoriak => {
            console.log(kategoriak);
            hely = document.getElementById(id)
            kategoriak.forEach(kategoria => {
                opcio = document.createElement('option')
                opcio.value = kategoria.id
                opcio.textContent = kategoria.nev
                hely.appendChild(opcio)
            })

        })
}
document.getElementById('valasszForm').addEventListener('submit',function(event){
    event.preventDefault(); //törli a submit gomb alap funkcióját

    //kinyerjük a kiválasztott kategória id-jét
    id = document.getElementById("kategoriak").value 
    ingatlanokAdatai(id)
})
ingatlanokAdatai("");
kategoriakAdatai('kategoriak')
kategoriakAdatai('kategoria')

maiDatum = new Date().toISOString()
document.getElementById('hirdetesDatuma').value = maiDatum.split('T')[0]