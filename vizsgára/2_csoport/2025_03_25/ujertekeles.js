document.getElementById('ertekelForm').addEventListener('submit', function(event){

    //törölni e beépített funkciót
    event.preventDefault()

    //kinyerjük az adatokat Form-ból
    adatok = new FormData(this)

})