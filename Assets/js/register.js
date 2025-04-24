document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault();
    

    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    const formData = {
        lastname: document.getElementById('Lastname').value,
        firstname: document.getElementById('Firstname').value,
        email: document.getElementById('Email').value,
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
       
        const alertDiv = document.createElement('div');
        
        if (data.message) {
            
            alertDiv.className = 'alert alert-success alert-dismissible fade show';
            alertDiv.setAttribute('role', 'alert');
            
            alertDiv.innerHTML = `
                <strong>Siker!</strong> ${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
        } else if (data.error) {
           
            alertDiv.className = 'alert alert-danger alert-dismissible fade show';
            alertDiv.setAttribute('role', 'alert');
            
            alertDiv.innerHTML = `
                <strong>Hiba!</strong> ${data.error}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
        }
        
        
        const form = document.getElementById('registrationForm');
        form.parentNode.insertBefore(alertDiv, form);
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
        
      
        const form = document.getElementById('registrationForm');
        form.parentNode.insertBefore(alertDiv, form);
    });
});