document.getElementById('LoginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    // Get form data
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Validate form data
    if (!email || !password) {
        document.getElementById('response').textContent = 'Please fill in all fields.';
        return;
    }

    // Prepare the request payload
    const requestData = { email, password };

    // Send POST request to the PHP login API
    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(requestData)
    })
    .then(response => response.json()) // Parse JSON response
    .then(data => {
        const responseDiv = document.getElementById('response');
        if (data.status === 'success') {
            responseDiv.style.color = 'green';
            responseDiv.textContent = "Sikeres bejelentkezés!";
            // Redirect user to another page (e.g., home or dashboard)
            window.location.href = 'main.html';  // Adjust the target page as needed
        } else {
            responseDiv.style.color = 'red';
            responseDiv.textContent = data.message;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const responseDiv = document.getElementById('response');
        responseDiv.style.color = 'red';
        responseDiv.style.backgroundColor="blue";
        responseDiv.textContent = 'An error occurred. Please try again later.';
    });
});
