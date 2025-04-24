document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
   
    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
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
            console.log("Sikeres bejelentkezés", data.user_id);
        }
        else {
         
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger alert-dismissible fade show';
            alertDiv.setAttribute('role', 'alert');
            
            alertDiv.innerHTML = `
                <strong>Hiba!</strong> ${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
          
            const form = document.getElementById('loginForm');
            form.parentNode.insertBefore(alertDiv, form);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
      
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
        alertDiv.setAttribute('role', 'alert');
        
        alertDiv.innerHTML = `
            <strong>Hiba!</strong> Váratlan hiba történt. Kérjük, próbálja újra később.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
     
        const form = document.getElementById('loginForm');
        form.parentNode.insertBefore(alertDiv, form);
    });
});