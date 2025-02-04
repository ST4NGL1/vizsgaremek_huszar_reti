
document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const formData = {
        email: document.getElementById('login_Email').value,
        password: document.getElementById('login_Password').value
    };
    console.log('Form Data:', formData); 
    fetch('../Assets/php/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
       

        if (data.success) {
            window.location.href = "../Views/home.html";
            console.log("Sikeres bejelentkezés",data.user_id);
        }
        else {
            alert('Login failed:'+ data.message); // Log the failure message
           
        }
       
    })
    .catch(error => console.error('Error:', error));

});