document.addEventListener('DOMContentLoaded', () => {
    loadProfile();
    loadOrders();
    document.getElementById('profile-form').addEventListener('submit', handleProfileUpdate);
    
    // Add event listeners for popup buttons
    document.getElementById('delete-account').addEventListener('click', showDeletePopup);
    document.getElementById('confirm-delete').addEventListener('click', deleteAccount);
    document.getElementById('cancel-delete').addEventListener('click', hideDeletePopup);
    document.getElementById('close-save-popup').addEventListener('click', hideSavePopup);
});

// Remove the unused loading functions since there's no loading element
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
                ordersContainer.innerHTML = '<p>Nincsenek korábbi rendelések.</p>';
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
                    <h3>Rendelés azonosító: ${orderId}</h3>
                    <p>Dátum: ${order.orderDate}</p>
                    <p>Teljes ár: ${order.totalPrice} Ft</p>
                    <div class="order-items">
                        ${order.items.map(item => `
                            <p>${item.quantity} x ${item.name} - ${item.price} Ft/db</p>
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
            showSavePopup();
        } else {
            alert('Hiba történt a profil frissítésekor: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error updating profile:', error);
    });
}

// Add the missing popup handling functions
function showSavePopup() {
    document.getElementById('save-popup').style.display = 'flex';
}

function hideSavePopup() {
    document.getElementById('save-popup').style.display = 'none';
}

function showDeletePopup() {
    document.getElementById('delete-popup').style.display = 'flex';
}

function hideDeletePopup() {
    document.getElementById('delete-popup').style.display = 'none';
}

function deleteAccount() {
    fetch('../Assets/php/delete_account.php', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'home.html';
        } else {
            alert('Hiba történt a fiók törlésekor: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error deleting account:', error);
    });
}
