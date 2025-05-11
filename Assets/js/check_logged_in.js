document.addEventListener('DOMContentLoaded', function() {
    
    function checkLoginStatus() {
        fetch('../Assets/php/session.php')
            .then(response => response.json())
            .then(data => {
                const checkoutElement = document.getElementById('checkout');
                
                if (data.status === 'logged_in') {
                   
                    checkoutElement.style.display = '';
                } else {
                    
                    checkoutElement.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error checking session:', error);
            });
    }

    
    checkLoginStatus();
});