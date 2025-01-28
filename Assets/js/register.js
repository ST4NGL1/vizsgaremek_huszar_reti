
document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const formData = {
        lastname: document.getElementById('Lastname').value,
        firstname: document.getElementById('Firstname').value,
        email: document.getElementById('Email').value,
        zipcode: document.getElementById('Zipcode').value,
        city: document.getElementById('City').value,
        address: document.getElementById('Address').value,
        password: document.getElementById('Password').value
    };

    fetch('../Assets/php/register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message || data.error);
    });
});