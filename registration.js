document.getElementById('RegistrationForm').addEventListener('submit', function(event) {
    event.preventDefault();  // Prevent the form from submitting normally

    // Get the form data
    const lastname = document.getElementById('lastname').value;
    const firstname = document.getElementById('firstname').value;
    const email = document.getElementById('email').value;
    const zipcode = document.getElementById('zipcode').value;
    const city = document.getElementById('city').value;
    const address = document.getElementById('address').value;
    const password = document.getElementById('password').value;

    const data = {
        lastname: lastname,
        firstname: firstname,
        email: email,
        zipcode: zipcode,
        city: city,
        address: address,
        password: password
    };  

    // Make the API request using fetch
    fetch('registration.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(responseData => {
        document.getElementById('response').textContent = responseData.message;
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('response').textContent = 'An error occurred';
    });
});