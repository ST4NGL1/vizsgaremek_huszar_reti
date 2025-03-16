fetch('../Assets/php/menu.php')
    .then(response => response.json())
    .then(data => {
        const menuContainer = document.getElementById('menu-container');
        menuContainer.innerHTML = '';

        const groupedMenu = {};
        data.forEach(item => {
            if (!groupedMenu[item.category]) {
                groupedMenu[item.category] = [];
            }
            groupedMenu[item.category].push(item);
        });

        for (const category in groupedMenu) {
            const categoryDiv = document.createElement('div');
            categoryDiv.classList.add('tangerine-bold', 'category');
            categoryDiv.innerText = category;
            menuContainer.appendChild(categoryDiv);

            groupedMenu[category].forEach(item => {
                const itemDiv = document.createElement('div');
                itemDiv.classList.add('tangerine-bold', 'menu-item');
                itemDiv.innerText = `${item.name} (${item.description})  ${item.price}Ft`;

                // Create Add to Cart button
                const orderButton = document.createElement('button');
                orderButton.classList.add('order-button');

                const svgIcon = document.createElement('img');
                svgIcon.src = '../Assets/images/svgs/cart.svg';
                svgIcon.alt = 'Cart Icon';
                svgIcon.style.width = '30px';
                svgIcon.style.height = '30px';

                orderButton.appendChild(svgIcon);
                orderButton.addEventListener('click', () => addToCart(item.id));
                
                itemDiv.appendChild(orderButton);
                menuContainer.appendChild(itemDiv);
            });
        }
    })
    .catch(error => console.error('Error fetching menu:', error));

function addToCart(itemId) {
    fetch('../Assets/php/add_to_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ itemId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Item added to cart!');
        } else {
            alert(data.message || 'Failed to add item to cart.');
        }
    })
    .catch(error => console.error('Error adding to cart:', error));
}
