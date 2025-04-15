document.getElementById('atlagForm').addEventListener('submit', function(event){

    event.preventDefault()

    adatok = new FormData(this) //'tantargy' kucson tartalmazza a tantárgy nevét

    fetch('./API/tanulok.php', {
        method: 'POST',
        body: adatok
    })
    .then(valasz => {
        if (!valasz.ok) { //HIBA
            return valasz.json().then(hiba => {
                throw new Error(hiba.error || 'Egyéb hiba lépett fel!')
            })
        }
        //nincs HIBA
        return valasz.json()
    })
    .then(adat => {
        console.log(adat);
        str = `${adat.tantargy_neve} tantárgy átlaga: ${adat.atlag}`
        alert(str)
    })
    .catch(hiba => alert(hiba.message))


})