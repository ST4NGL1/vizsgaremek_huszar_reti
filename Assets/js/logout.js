
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
            if (data.status === "success") {
                checkSession();
            }
        });
    });

    document.getElementById("logout").addEventListener("click", function () {
        fetch("../Assets/php/logout.php", {
            method: "DELETE" // RESTful API should use DELETE for logout
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            checkSession(); // Refresh UI to reflect logout
        })
        .catch(error => console.error("Logout error:", error));
    });
    
    });


function checkSession() {
    fetch("../Assets/php/session.php")
    .then(response => response.json())
    .then(data => {
        if (data.status === "logged_in") {
            
            document.getElementById("login").style.backgroundColor = "green";
            document.getElementById("logout").style.backgroundColor = "red";
        } else {
            document.getElementById("login").style.backgroundColor = "blue";
            document.getElementById("logout").style.backgroundColor = "white";
        }
    });
}
function logoutUser() {
    fetch("../api/auth.php", { method: "DELETE" })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload(); // Refresh to update UI
            }
        })
        .catch(error => console.error("Logout error:", error));
}