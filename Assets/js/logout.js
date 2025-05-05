document.addEventListener("DOMContentLoaded", function () {
    checkSession();

    document.getElementById("login").addEventListener("submit", function (e) {
        e.preventDefault();
        const email = document.getElementById("email").value;
        const jelszo = document.getElementById("jelszo").value;

        fetch("../Assets/php/login.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `email=${email}&jelszo=${jelszo}`
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                checkSession();
            }
        })
        .catch(error => console.error("Login error:", error));
    });

    document.getElementById("logout").addEventListener("click", logoutUser);
});

function checkSession() {
    fetch("../Assets/php/session.php")
    .then(response => response.json())
    .then(data => {
        if (data.status === "logged_in") {
            document.getElementById("login").style.display = "none"; 
            document.getElementById("logout").style.display = "block"; 
        } else {
            document.getElementById("login").style.display = "block"; 
            document.getElementById("logout").style.display = "none"; 
        }
    })
    .catch(error => console.error("Session check error:", error));
}

function logoutUser() {
    fetch("../Assets/php/logout.php", { method: "DELETE" })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === "success") {
                checkSession(); 
            }
        })
        .catch(error => console.error("Logout error:", error));
}

document.addEventListener('DOMContentLoaded', () => {
    checkAuthStatus();
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

function logoutUser() {
    fetch('../Assets/php/logout.php', { method: 'DELETE' })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Sikeres kijelentkezés.');
                window.location.href = '../Views/home.html';
            } else {
                alert('Sikertelen kijelentkezés.');
            }
        })
        .catch(error => console.error('Error logging out:', error));
}