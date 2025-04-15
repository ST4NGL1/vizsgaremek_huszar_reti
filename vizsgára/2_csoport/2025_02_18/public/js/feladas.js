//kategóriák beemelése a legördülő listába
fetch('/13_G/2024_12_04/kategoria')
    .then(valasz => valasz.json())
    .then(valasz => {
        const hely = document.getElementById('kategoria');
        valasz.forEach(kategoria =>{
            const option = document.createElement('option'); //HTML tag-t hoz létre, aminek írjuk a tulajdonságait: value, textContent
            option.value = kategoria.id;
            option.textContent = kategoria.nev;
            hely.appendChild(option);
        });

    });

//hirdetés dátuma az aktuális dátum legyen
document.getElementById('hirdetesDatuma').value = new Date().toISOString().split('T')[0];

//A submit eseményre bekötünk egy függvényt a hozzadForm-ban, ami egy POST kérést küld a szerver felé
//a Form adataival, és feldolgozza a választ

document.getElementById('hozzadForm').addEventListener('submit', function(event){
    event.preventDefault() //törli a submit esemény alapértelmezett cselekvést

    //A form adatainak kinyerése
    const adatok = new FormData(this); //this ez a hozzadForm 

    //kérés küldése metódus POST törzs az adatok
    fetch('/13_G/2024_12_04/ingatlan',{
        method: 'POST',
        body: adatok
    })
    .then(valasz =>{
        if(!valasz.ok){ //ha hiba történt, a válasz státusza nem 201-es kód
            //kivételdobás catch elkapja
            throw new Error('nincs válasz a szervertől')
        }
        return valasz.json()
    })
    .then(adat => { //sikeres adatrögzítés
        console.log(adat.id)
        window.location.href = "/13_G/2024_12_04/"  //visszaküldöm aiz index.html-re
    })
    .catch(error => {
        console.log("Hiba történt: ". error)
    })
})