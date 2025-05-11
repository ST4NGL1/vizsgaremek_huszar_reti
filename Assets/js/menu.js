
function checkLoginStatus() {
    return fetch('../Assets/php/session.php')
        .then(response => response.json())
        .then(data => {
            return data.status === "logged_in";
        })
        .catch(error => {
            console.error('Error checking login status:', error);
            return false;
        });
}


function addToCart(itemId) {
    checkLoginStatus().then(isLoggedIn => {
        if (isLoggedIn) {
           
            fetch('../Assets/php/add_to_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ itemId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showPopup();
                } else {
                    alert(data.message || 'Tétel hozzáadása sikertelen.');
                }
            })
            .catch(error => console.error('Error adding to cart:', error));
        } else {
          
            showLoginRequiredPopup();
        }
    });
}


function showLoginRequiredPopup() {
    const loginPopup = document.getElementById('login-required-popup');
    loginPopup.style.display = 'flex';
}

function closeLoginRequiredPopup() {
    const loginPopup = document.getElementById('login-required-popup');
    loginPopup.style.display = 'none';
}


function showPopup() {
    const popup = document.getElementById('popup');
    popup.style.display = 'flex';
}

function closePopup() {
    const popup = document.getElementById('popup');
    popup.style.display = 'none';
}


document.addEventListener('DOMContentLoaded', () => {
    fetch('../Assets/php/menu.php')
        .then(response => response.json())
        .then(data => {
            const menuContainer = document.getElementById('menu-container');
            menuContainer.innerHTML = '';

            const groupedMenu = {};
            data.forEach(item => {
                if (!groupedMenu[item.CATEGORY]) {
                    groupedMenu[item.CATEGORY] = [];
                }
                groupedMenu[item.CATEGORY].push(item);
            });

            for (const category in groupedMenu) {
                const categoryDiv = document.createElement('div');
                categoryDiv.classList.add('tangerine-bold', 'category');
                categoryDiv.innerText = category;
                menuContainer.appendChild(categoryDiv);

                groupedMenu[category].forEach(item => {
                    const itemDiv = document.createElement('div');
                    itemDiv.classList.add('tangerine-bold', 'menu-item');
                    itemDiv.innerHTML = `
                        ${item.NAME} (${item.DESCRIPTION}) ${item.PRICE}Ft
                        <div tabindex="0" class="plusButton">
                            <svg class="plusIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                <g mask="url(#mask0_21_345)">
                                    <path d="M13.75 23.75V16.25H6.25V13.75H13.75V6.25H16.25V13.75H23.75V16.25H16.25V23.75H13.75Z"></path>
                                </g>
                            </svg>
                        </div>
                    `;

                    const orderButton = itemDiv.querySelector('.plusButton');
                    orderButton.addEventListener('click', () => addToCart(item.ITEMID));
                    
                    menuContainer.appendChild(itemDiv);
                });
            }
        })
        .catch(error => console.error('Error fetching menu:', error));

    
    const continueShoppingBtn = document.getElementById('continue-shopping');
    if (continueShoppingBtn) {
        continueShoppingBtn.addEventListener('click', closePopup);
    }
    
    const goToCartBtn = document.getElementById('go-to-cart');
    if (goToCartBtn) {
        goToCartBtn.addEventListener('click', () => {
            window.location.href = 'checkout.html';
        });
    }
    
  
    const goToLoginBtn = document.getElementById('go-to-login-btn');
    if (goToLoginBtn) {
        goToLoginBtn.addEventListener('click', () => {
            window.location.href = '../Views/register.html';
        });
    }
    
    const closeLoginPopupBtn = document.getElementById('close-login-popup-btn');
    if (closeLoginPopupBtn) {
        closeLoginPopupBtn.addEventListener('click', closeLoginRequiredPopup);
    }
});
