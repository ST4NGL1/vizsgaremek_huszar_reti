document.addEventListener("DOMContentLoaded", function () {
    try {
        
        checkAuthStatus();

       
        setupLogoutModal();
    } catch (error) {
        console.error("Error in logout.js initialization:", error);
    }
});

function checkAuthStatus() {
    fetch('../Assets/php/session.php')
        .then(response => response.json())
        .then(data => {
            const loginLink = document.getElementById('login');
            const profileLink = document.getElementById('profile');
            const logoutLink = document.getElementById('logout');
            const checkoutLink = document.getElementById('checkout-link');

            if (data.status === 'logged_in') {
                
                if (loginLink) loginLink.style.display = 'none';
                if (profileLink) profileLink.style.display = 'block';
                if (logoutLink) logoutLink.style.display = 'block';
                if (checkoutLink) {
                    checkoutLink.addEventListener('click', (e) => {
                        e.preventDefault();
                        window.location.href = '../Views/checkout.html';
                    });
                }
            } else {
              
                if (loginLink) loginLink.style.display = 'block';
                if (profileLink) profileLink.style.display = 'none';
                if (logoutLink) logoutLink.style.display = 'none';
                if (checkoutLink) {
                    checkoutLink.addEventListener('click', (e) => {
                        e.preventDefault();
                        window.location.href = '../Views/register.html';
                    });
                }
            }
        })
        .catch(error => console.error('Error checking auth status:', error));
}

function setupLogoutModal() {
    
    const logoutButton = document.querySelector('#logout a');
    const modal = document.getElementById('logoutModal');
    const confirmBtn = document.getElementById('confirmLogout');
    const cancelBtn = document.getElementById('cancelLogout');
    
    
    if (!logoutButton || !modal || !confirmBtn || !cancelBtn) {
        console.log('One or more logout elements not found. Skipping logout modal setup.');
        return;
    }
    
   
    logoutButton.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation(); 
        modal.style.display = 'flex';
    });
    
    
    confirmBtn.addEventListener('click', function() {
       
        fetch('../Assets/php/logout.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            try {
                return response.json();
            } catch (error) {
               
                window.location.href = '../Views/home.html';
                throw error;
            }
        })
        .then(data => {
            if (data && data.status === 'success') {
                window.location.href = '../Views/home.html';
            } else {
                console.error('Logout failed:', data ? data.message : 'Unknown error');
                window.location.href = '../Views/home.html';
            }
        })
        .catch(error => {
            console.error('Error during logout:', error);
            window.location.href = '../Views/home.html'; 
        });
    });
    
   
    cancelBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    

    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
}