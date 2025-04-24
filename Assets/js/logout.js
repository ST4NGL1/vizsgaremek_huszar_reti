document.addEventListener("DOMContentLoaded", function () {
    initializeApp();
});

function initializeApp() {
    checkSession();

    const loginForm = document.getElementById("login");
    const logoutButton = document.getElementById("logout");
    const checkoutLink = document.getElementById("checkout-link");

    if (loginForm) {
        loginForm.addEventListener("submit", handleLogin);
    }

    if (logoutButton) {
        logoutButton.addEventListener("click", logoutUser);
    }

    if (checkoutLink) {
        checkoutLink.addEventListener("click", handleCheckout);
    }
}

function handleLogin(e) {
    e.preventDefault();
    const email = document.getElementById("email").value;
    const jelszo = document.getElementById("jelszo").value;

    fetch("../Assets/php/login.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `email=${encodeURIComponent(email)}&jelszo=${encodeURIComponent(jelszo)}`
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                checkSession();
            }
        })
        .catch(error => console.error("Login error:", error));
}

function checkSession() {
    fetch("../Assets/php/session.php")
        .then(response => response.json())
        .then(data => updateUI(data.status === "logged_in"))
        .catch(error => console.error("Session check error:", error));
}

function updateUI(isLoggedIn) {
    const loginForm = document.getElementById("login");
    const logoutButton = document.getElementById("logout");
    const profileLink = document.getElementById("profile");

    if (isLoggedIn) {
        if (loginForm) loginForm.style.display = "none";
        if (logoutButton) logoutButton.style.display = "block";
        if (profileLink) profileLink.style.display = "block";
    } else {
        if (loginForm) loginForm.style.display = "block";
        if (logoutButton) logoutButton.style.display = "none";
        if (profileLink) profileLink.style.display = "none";
    }
}

function logoutUser() {
    fetch("../Assets/php/logout.php", { method: "DELETE" })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === "success") {
                window.location.href = "../Views/home.html";
            }
        })
        .catch(error => console.error("Logout error:", error));
}

function handleCheckout(e) {
    e.preventDefault();
    fetch("../Assets/php/session.php")
        .then(response => response.json())
        .then(data => {
            const targetPage = data.status === "logged_in" ? "../Views/checkout.html" : "../Views/register.html";
            window.location.href = targetPage;
        })
        .catch(error => console.error("Checkout error:", error));
}