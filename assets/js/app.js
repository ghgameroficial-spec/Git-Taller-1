// JavaScript Handler - Taller DevOps
document.addEventListener('DOMContentLoaded', () => {
    // 1. Live Catalog Filter & Category Selection
    const searchInput = document.getElementById('searchInput');
    const categoryBtns = document.querySelectorAll('.cat-btn');
    const productCards = document.querySelectorAll('.product-card');

    let activeCategory = 'all';

    function filterProducts() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';

        productCards.forEach(card => {
            const title = card.dataset.title ? card.dataset.title.toLowerCase() : '';
            const desc = card.dataset.desc ? card.dataset.desc.toLowerCase() : '';
            const cat = card.dataset.category ? card.dataset.category : '';

            const matchesSearch = title.includes(query) || desc.includes(query);
            const matchesCat = activeCategory === 'all' || cat === activeCategory;

            if (matchesSearch && matchesCat) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterProducts);
    }

    categoryBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            categoryBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activeCategory = btn.dataset.cat;
            filterProducts();
        });
    });

    // 2. Form Client-Side Validation
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', (e) => {
            const pwd = document.getElementById('password').value;
            const confirmPwd = document.getElementById('confirm_password').value;

            if (pwd.length < 6) {
                e.preventDefault();
                alert('La contraseña debe tener al menos 6 caracteres.');
                return;
            }

            if (pwd !== confirmPwd) {
                e.preventDefault();
                alert('Las contraseñas no coinciden. Por favor verifique.');
                return;
            }
        });
    }
});

function buyPromo(productName, promoPrice) {
    alert(`¡Excelente elección!\nHas reservado la oferta: "${productName}" por \$${promoPrice} USD.\nSe enviarán los detalles de la compra a tu correo de registro.`);
}
