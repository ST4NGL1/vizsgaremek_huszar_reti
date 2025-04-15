document.getElementById('torolForm').addEventListener('submit', function(event){
    event.preventDefault();
    const id = document.getElementById('id').value //kivesszük az input mező értékét, a törlendő elem id-jét
    //a végpont neve után ? jellel lehet paraméterezni id lesz a paraméter neve ${id} értéke
    fetch(`/13_G/2024_12_04/ingatlan?id=${id}`,{
        method: 'DELETE'
    })
    .then(valasz => {
        if(!valasz.ok){
            throw new Error('Hiba történt a törlésnél')
        }
        return valasz.text()
    })
    .then(szoveg => {
        if(szoveg){ //ha nem üres szöveg
            alert(szoveg)
        }
        window.location.href = "/13_G/2024_12_04/"
    })
    .catch(error => {
        console.error('Hiba: ', error)
    })

})