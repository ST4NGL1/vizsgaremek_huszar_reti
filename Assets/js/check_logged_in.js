document.addEventListener('DOMContentLoaded', function() {
    // Function to check login status using the existing session.php
    function checkLoginStatus() {
        fetch('../Assets/php/session.php')
            .then(response => response.json())
            .then(data => {
                const checkoutElement = document.getElementById('checkout');
                
                if (data.status === 'logged_in') {
                    // User is logged in, show checkout option
                    checkoutElement.style.display = '';
                } else {
                    // User is not logged in, hide checkout option
                    checkoutElement.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error checking session:', error);
            });
    }

    // Run check on page load
    checkLoginStatus();
});