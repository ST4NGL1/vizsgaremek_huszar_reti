document.addEventListener('DOMContentLoaded', () => {
    loadCart();
    document.getElementById('checkout-form').addEventListener('submit', handleCheckout);
});

function loadCart() {
    fetch('../Assets/php/cart.php')
        .then(response => response.json())
        .then(data => {
            const cartContainer = document.getElementById('cart-items');
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
                <select data-item-id="${item.ITEMID}" class="quantity-select">
                ${[...Array(5).keys()].map(i => `<option value="${i + 1}">${i + 1}</option>`).join('')}
                </select>
                <button class="remove-button" data-item-id="${item.ITEMID}">❌</button>
                `;
                
                cartContainer.appendChild(itemDiv);
            });

            document.querySelectorAll('.remove-button').forEach(button => {
                button.addEventListener('click', () => removeFromCart(button.dataset.itemId));
            });

            document.querySelectorAll('.quantity-select').forEach(select => {
                select.addEventListener('change', updateTotalAmount);
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
        const quantity = parseInt(item.querySelector('.quantity-select').value);
        totalAmount += price * quantity;
    });

    document.getElementById('total-amount').textContent = totalAmount;
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
    document.getElementById('loading').style.display = 'flex'; // Show loading indicator
    setTimeout(submitCheckout, 1000); // Delay the checkout by 1 second
}



function submitCheckout() {
    const formData = new FormData(document.getElementById('checkout-form'));
    const personalInfo = Object.fromEntries(formData.entries());

    const cartItems = Array.from(document.querySelectorAll('.quantity-select')).map(select => ({
        itemId: select.dataset.itemId,
        quantity: select.value
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
        document.getElementById('loading').style.display = 'none'; // Hide loading indicator
        if (data.success) {
           // alert('Checkout successful!');
            loadCart();
        } else {
            alert('Failed to checkout.');
        }
    })
    .catch(error => {
        document.getElementById('loading').style.display = 'none'; // Hide loading indicator
        console.error('Error during checkout:', error);
    });
}