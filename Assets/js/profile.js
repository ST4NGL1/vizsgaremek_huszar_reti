document.addEventListener('DOMContentLoaded', () => {
    loadProfile();
    loadOrders();
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
    fetch('../Assets/php/order_history.php')
        .then(response => response.json())
        .then(data => {
            const ordersContainer = document.getElementById('orders-container');
            ordersContainer.innerHTML = '';

            if (data.length === 0) {
                ordersContainer.innerHTML = '<p>No previous orders found.</p>';
                hideLoading();
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
                    <h3>Order ID: ${orderId}</h3>
                    <p>Date: ${order.orderDate}</p>
                    <p>Total Price: ${order.totalPrice} Ft</p>
                    <div class="order-items">
                        ${order.items.map(item => `
                            <p>${item.quantity} x ${item.name} - ${item.price} Ft/db</p>
                        `).join('')}
                    </div>
                `;
                ordersContainer.appendChild(orderElement);
            });

            hideLoading();
        })
        .catch(error => {
            console.error('Error loading orders:', error);
            hideLoading();
        });
}
