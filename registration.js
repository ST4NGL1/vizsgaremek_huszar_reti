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

    // Simple client-side validation
    if (!firstname || !lastname || !email || !zipcode || !city || !address || !password) {
        document.getElementById('response').textContent = 'Minden mező kitöltése kötelező!';
        return;
    }

    // Validate email format
    if (!/\S+@\S+\.\S+/.test(email)) {
        document.getElementById('response').textContent = 'Érvénytelen e-mail cím!';
        return;
    }

    // Check password length
    if (password.length < 8) {
        document.getElementById('response').textContent = 'A jelszó minimum 8 karakter hosszú kell legyen!';
        return;
    }

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

        // If registration is successful, you could reset the form or redirect the user
        if (responseData.message === 'Sikeres regisztráció!') {
            // Optionally, clear the form fields
            document.getElementById('RegistrationForm').reset();
            // Or redirect the user to another page, e.g.:
            // window.location.href = 'login.html';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('response').textContent = 'Hiba történt a regisztráció közben!';
    });
});



