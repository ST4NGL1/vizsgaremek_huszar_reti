document.addEventListener('DOMContentLoaded', () => {
    loadProfile();
    loadOrders();
    document.getElementById('profile-form').addEventListener('submit', handleProfileUpdate);
    document.getElementById('save').addEventListener('click', handleSave);
    document.getElementById('delete-account').addEventListener('click', showDeletePopup);
    document.getElementById('close-save-popup').addEventListener('click', closeSavePopup);
    document.getElementById('confirm-delete').addEventListener('click', handleDeleteAccount);
    document.getElementById('cancel-delete').addEventListener('click', closeDeletePopup);
});

function loadProfile() {
    fetch('../Assets/php/get_user_info.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('Lastname').value = data.LASTNAME;
            document.getElementById('Firstname').value = data.FIRSTNAME;
            document.getElementById('Email').value = data.EMAIL;
        })
        .catch(error => {
            console.error('Error loading profile:', error);
        });
}

function loadOrders() {
    fetch('../Assets/php/order_history.php')
        .then(response => response.json())
        .then(data => {
            const ordersContainer = document.getElementById('orders-container');
            ordersContainer.innerHTML = '';

            if (data.length === 0) {
                ordersContainer.innerHTML = '<p>No previous orders found.</p>';
                return;
            }

            const ordersMap = new Map();

            data.forEach(order => {
                if (!ordersMap.has(order.ORDERID)) {
                    ordersMap.set(order.ORDERID, {
                        orderDate: order.ORDERDATE,
                        totalPrice: order.TOTALPRICE,
                        items: []
                    });
                }
                ordersMap.get(order.ORDERID).items.push({
                    name: order.NAME,
                    quantity: order.QUANTITY,
                    price: order.PRICE
                });
            });

            ordersMap.forEach((order, orderId) => {
                const orderElement = document.createElement('div');
                orderElement.classList.add('order-item');
                orderElement.innerHTML = `
                    <h3>Rendelés azonosítója: ${orderId}</h3>
                    <p>Dátum: ${order.orderDate}</p>
                    <p>Teljes összeg: ${order.totalPrice} Ft</p>
                    <div class="order-items">
                        ${order.items.map(item => `
                            <p>${item.quantity} x ${item.name}</p>
                        `).join('')}
                    </div>
                `;
                ordersContainer.appendChild(orderElement);
            });
        })
        .catch(error => {
            console.error('Error loading orders:', error);
        });
}

function handleProfileUpdate(event) {
    event.preventDefault();

    const formData = new FormData(document.getElementById('profile-form'));
    const profileData = Object.fromEntries(formData.entries());

    fetch('../Assets/php/update_user_info.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(profileData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Profile updated successfully!');
        } else {
            alert('Failed to update profile: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error updating profile:', error);
    });
}

function handleSave(event) {
    event.preventDefault();
    // Perform save action here (e.g., AJAX request to save profile)
    // On success, show the save popup
    document.getElementById('save-popup').style.display = 'flex';
}

function closeSavePopup() {
    document.getElementById('save-popup').style.display = 'none';
}

function showDeletePopup() {
    document.getElementById('delete-popup').style.display = 'flex';
}

function closeDeletePopup() {
    document.getElementById('delete-popup').style.display = 'none';
}

function handleDeleteAccount() {
    if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
        fetch('../Assets/php/delete_account.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'delete_account' })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Your account has been deleted.');
                window.location.href = 'register.html';
            } else {
                alert('Failed to delete account: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error deleting account:', error);
            alert('An error occurred while deleting your account. Please try again later.');
        });
    }
}
