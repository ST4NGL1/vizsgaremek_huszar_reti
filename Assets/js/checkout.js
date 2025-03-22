document.addEventListener('DOMContentLoaded', () => {
    loadCart();
    document.getElementById('checkout-form').addEventListener('submit', handleCheckout);
    document.getElementById('close-popup').addEventListener('click', closePopup);
    document.getElementById('go-to-profile').addEventListener('click', () => {
        window.location.href = 'profile.html';
    });

    const menuBtn = document.getElementById('menu-btn');
    const navLinks = document.getElementById('nav-links');

    menuBtn.addEventListener('click', () => {
        navLinks.classList.toggle('show');
    });
});

function loadCart() {
    fetch('../Assets/php/cart.php')
        .then(response => response.json())
        .then(data => {
            const cartContainer = document.getElementById('cart-container');
            cartContainer.innerHTML = '';
            
            if (data.length === 0) {
                cartContainer.innerHTML = '<p class="tangerine-bold">A kosár üres.</p>';
                updateTotalAmount();
                return;
            }
            
            data.forEach(item => {
                const itemDiv = document.createElement('div');
                itemDiv.classList.add('cart-item');
                itemDiv.innerHTML = `
                    <span>${item.NAME} - ${item.PRICE}Ft</span>
                    <input type="number" data-item-id="${item.ITEMID}" class="quantity-input" value="${item.QUANTITY}" min="1" max="10">
                    <button class="remove-button tooltip" data-item-id="${item.ITEMID}"> 
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" height="30" width="30">
                            <path fill="#FFFFFF" d="M8.78842 5.03866C8.86656 4.96052 8.97254 4.91663 9.08305 4.91663H11.4164C11.5269 4.91663 11.6329 4.96052 11.711 5.03866C11.7892 5.11681 11.833 5.22279 11.833 5.33329V5.74939H8.66638V5.33329C8.66638 5.22279 8.71028 5.11681 8.78842 5.03866ZM7.16638 5.74939V5.33329C7.16638 4.82496 7.36832 4.33745 7.72776 3.978C8.08721 3.61856 8.57472 3.41663 9.08305 3.41663H11.4164C11.9247 3.41663 12.4122 3.61856 12.7717 3.978C13.1311 4.33745 13.333 4.82496 13.333 5.33329V5.74939H15.5C15.9142 5.74939 16.25 6.08518 16.25 6.49939C16.25 6.9136 15.9142 7.24939 15.5 7.24939H15.0105L14.2492 14.7095C14.2382 15.2023 14.0377 15.6726 13.6883 16.0219C13.3289 16.3814 12.8414 16.5833 12.333 16.5833H8.16638C7.65805 16.5833 7.17054 16.3814 6.81109 16.0219C6.46176 15.6726 6.2612 15.2023 6.25019 14.7095L5.48896 7.24939H5C4.58579 7.24939 4.25 6.9136 4.25 6.49939C4.25 6.08518 4.58579 5.74939 5 5.74939H6.16667H7.16638ZM7.91638 7.24996H12.583H13.5026L12.7536 14.5905C12.751 14.6158 12.7497 14.6412 12.7497 14.6666C12.7497 14.7771 12.7058 14.8831 12.6277 14.9613C12.5495 15.0394 12.4436 15.0833 12.333 15.0833H8.16638C8.05588 15.0833 7.94989 15.0394 7.87175 14.9613C7.79361 14.8831 7.74972 14.7771 7.74972 14.6666C7.74972 14.6412 7.74842 14.6158 7.74584 14.5905L6.99681 7.24996H7.91638Z" clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                        <span class="tooltiptext">Törlés</span>
                    </button>
                `;
                
                cartContainer.appendChild(itemDiv);
            });

            document.querySelectorAll('.remove-button').forEach(button => {
                button.addEventListener('click', () => removeFromCart(button.dataset.itemId));
            });

            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', updateQuantity);
            });

            updateTotalAmount();
        })
        .catch(error => console.error('Error loading cart:', error));
}

function updateTotalAmount() {
    const cartItems = Array.from(document.querySelectorAll('.cart-item'));
    let totalAmount = 0;

    cartItems.forEach(item => {
        const price = parseInt(item.querySelector('span').textContent.split(' - ')[1].replace('Ft', ''));
        const quantity = parseInt(item.querySelector('.quantity-input').value);
        totalAmount += price * quantity;
    });

    document.getElementById('total-amount').textContent = totalAmount;
}

function updateQuantity(event) {
    const itemId = event.target.getAttribute('data-item-id');
    const quantity = event.target.value;

    fetch('../Assets/php/cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `item_id=${itemId}&quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            updateTotalAmount();
        } else {
            alert('Failed to update quantity.');
        }
    })
    .catch(error => console.error('Error updating quantity:', error));
}

function removeFromCart(itemId) {
    fetch('../Assets/php/remove_from_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ itemId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadCart();
        } else {
            alert('Failed to remove item from cart.');
        }
    })
    .catch(error => console.error('Error removing item:', error));
}

function handleCheckout(event) {
    event.preventDefault();
    submitCheckout();
}

function submitCheckout() {
    const formData = new FormData(document.getElementById('checkout-form'));
    const personalInfo = Object.fromEntries(formData.entries());

    const cartItems = Array.from(document.querySelectorAll('.quantity-input')).map(input => ({
        itemId: input.dataset.itemId,
        quantity: input.value
    }));

    const checkoutData = {
        personalInfo,
        cartItems
    };

    fetch('../Assets/php/checkout.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(checkoutData)
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // Log the response to see what is being returned
        if (data.success) {
            setTimeout(() => {
                showPopup();
                loadCart();
            }, 1000); // 1-second delay before showing the popup
        } else {
            alert('Failed to checkout: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error during checkout:', error);
    });
}

function showPopup() {
    const popup = document.getElementById('popup');
    const currentTime = new Date();
    currentTime.setHours(currentTime.getHours() + 1);
    const pickupTime = currentTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    document.getElementById('pickup-time').textContent = `Rendelésed készen lesz ${pickupTime}-ra`;
    popup.style.display = 'flex';
}

function closePopup() {
    const popup = document.getElementById('popup');
    popup.style.display = 'none';
}