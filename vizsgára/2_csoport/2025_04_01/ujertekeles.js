document.getElementById('ertekelForm').addEventListener('submit', function(event){

    //törölni e beépített funkciót
    event.preventDefault()

    //kinyerjük az adatokat Form-ból
    adatok = new FormData(this) //adatok változónak létezik 'tantargy', 'tanuloId' és 'jegy' kulcsa --> ezek name paraméterek a Form-ban

    fetch('./API/ujertekeles.php', {
        method: 'POST',
        body: adatok
    })
    .then(valasz => {
        if (!valasz.ok) {//HIBA
            return valasz.json().then(hiba => {
                throw new Error(hiba.error || 'Hiba lépett fel!')
            })
        }
        //nincs HIBA
        return valasz.json()
    })
    .then(adat => {
        console.log(adat); //ellenőrzés, megvan-e a válasz
        str = `${adat.tanulo.nev} tanuló ${adat.tanulo.tantargy} tantárgyból kapott érdemjegye: ${adat.tanulo.jegy}, rögzítve!`
        alert(str)
    })
    .catch(hiba => alert(hiba.message))


})