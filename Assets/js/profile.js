document.addEventListener('DOMContentLoaded', () => {
    loadProfile();
    loadOrders();
    document.getElementById('profile-form').addEventListener('submit', handleProfileUpdate);
});

function showLoading() {
    document.getElementById('loading').style.display = 'flex';
}

function hideLoading() {
    document.getElementById('loading').style.display = 'none';
}

function loadProfile() {
    showLoading();
    fetch('../Assets/php/get_user_info.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('Lastname').value = data.LASTNAME;
            document.getElementById('Firstname').value = data.FIRSTNAME;
            document.getElementById('Email').value = data.EMAIL;
           
            hideLoading();
        })
        .catch(error => {
            console.error('Error loading profile:', error);
            hideLoading();
        });
}

function loadOrders() {
    showLoading();
    fetch('../Assets/php/get_orders.php')
        .then(response => response.json())
        .then(data => {
            const ordersList = document.getElementById('orders-list');
            ordersList.innerHTML = '';
            data.forEach(order => {
                const orderDiv = document.createElement('div');
                orderDiv.classList.add('order-item');
                orderDiv.innerHTML = `
                    <p>Rendelés ID: ${order.ORDERID}</p>
                    <p>Dátum: ${order.ORDERDATE}</p>
                    <p>Összeg: ${order.TOTALPRICE} Ft</p>
                `;
                ordersList.appendChild(orderDiv);
            });
            hideLoading();
        })
        .catch(error => {
            console.error('Error loading orders:', error);
            hideLoading();
        });
}
