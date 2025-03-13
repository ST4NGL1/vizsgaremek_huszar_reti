document.addEventListener('DOMContentLoaded', () => {
    loadCart();
});

function loadCart() {
    fetch('../Assets/php/cart.php')
        .then(response => response.json())
        .then(data => {
            const cartContainer = document.getElementById('cart-items');
            cartContainer.innerHTML = '';

            if (data.length === 0) {
                cartContainer.innerHTML = '<p class="tangerine-bold">A kosár üres.</p>';
                return;
            }

            data.forEach(item => {
                const itemDiv = document.createElement('div');
                itemDiv.classList.add('cart-item');
                itemDiv.innerHTML = `<span>${item.name} - ${item.price}Ft</span>`;

                const removeButton = document.createElement('button');
                removeButton.innerText = '❌';
                removeButton.addEventListener('click', () => removeFromCart(item.id));
                
                itemDiv.appendChild(removeButton);
                cartContainer.appendChild(itemDiv);
            });
        })
        .catch(error => console.error('Error loading cart:', error));
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
