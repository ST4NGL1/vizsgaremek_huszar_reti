

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
            categoryDiv.classList.add('category');
            categoryDiv.innerText = category;

            menuContainer.appendChild(categoryDiv);

            groupedMenu[category].forEach(item => {
                const itemDiv = document.createElement('div');
                itemDiv.classList.add('menu-item');
                itemDiv.innerText = `${item.name} - $${item.price}`;
                menuContainer.appendChild(itemDiv);
            });
        }
    })
    .catch(error => console.error('Error fetching menu:', error));
