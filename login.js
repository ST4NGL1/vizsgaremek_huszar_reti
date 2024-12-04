document.getElementById('LoginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    // Get form data
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Validate form data
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!email || !password) {
        document.getElementById('response').textContent = 'Please fill in all fields.';
        return;
    }
    if (!emailRegex.test(email)) {
        document.getElementById('response').textContent = 'Please enter a valid email address.';
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
        // Clear loading text
        responseDiv.textContent = ''; // Clear previous messages

        if (data.status === 'success') {
            responseDiv.style.color = 'green';
            responseDiv.textContent = "Sikeres bejelentkezés!"; // Successful login message
            // Redirect user to another page (e.g., home or dashboard)
            window.location.href = 'main.html';  // Adjust the target page as needed
        } else {
            responseDiv.style.color = 'red';
            responseDiv.textContent = data.message; // Display error message
        }
    })
    .catch(error => {
        console.error('Error:', error); // Log the error in the console
        responseDiv.style.color = 'red';
        responseDiv.style.backgroundColor = "blue";
        responseDiv.textContent = 'An error occurred. Please try again later.'; // General error message
    });
});

