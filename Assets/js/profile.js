document.addEventListener('DOMContentLoaded', () => {
    checkAuthStatus();
    loadUserProfile();
    document.getElementById('profile-form').addEventListener('submit', updateUserProfile);
});

function checkAuthStatus() {
    fetch('../Assets/php/session.php')
        .then(response => response.json())
        .then(data => {
            const loginLink = document.getElementById('login');
            const profileLink = document.getElementById('profile');
            const logoutLink = document.getElementById('logout');

            if (data.status === 'logged_in') {
                loginLink.style.display = 'none';
                profileLink.style.display = 'block';
                logoutLink.style.display = 'block';
            } else {
                loginLink.style.display = 'block';
                profileLink.style.display = 'none';
                logoutLink.style.display = 'none';
                window.location.href = '../Views/register.html';
            }
        })
        .catch(error => console.error('Error checking auth status:', error));
}

function loadUserProfile() {
    fetch('../Assets/php/get_user_info.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('Lastname').value = data.LASTNAME;
            document.getElementById('Firstname').value = data.FIRSTNAME;
            document.getElementById('Email').value = data.EMAIL;
           
        })
        .catch(error => console.error('Error loading user profile:', error));
}

function updateUserProfile(event) {
    event.preventDefault();

    const formData = new FormData(event.target);
    const userProfile = Object.fromEntries(formData.entries());

    fetch('../Assets/php/update_user_info.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(userProfile)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Profile updated successfully!');
        } else {
            alert('Failed to update profile.');
        }
    })
    .catch(error => console.error('Error updating user profile:', error));
}