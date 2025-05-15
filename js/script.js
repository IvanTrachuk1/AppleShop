// Файл index.html
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('.search-bar input');
    const productCards = document.querySelectorAll('.product-card');

    // Обробник події для пошуку
    searchInput.addEventListener('input', function () {
        const searchTerm = searchInput.value.toLowerCase();

        productCards.forEach(card => {
            const productName = card.querySelector('h3').textContent.toLowerCase();

            if (productName.includes(searchTerm)) {
                card.style.display = ''; // Показати картку
            } else {
                card.style.display = 'none'; // Сховати картку
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("authModal");
    const openModalBtn = document.getElementById("openModal");

    // Відкриття модального вікна
    openModalBtn.addEventListener("click", function (event) {
        event.preventDefault();
        modal.style.display = "flex";
    });

    // Закриття при кліку поза формою
    window.addEventListener("click", function (event) {
        const modalContent = modal.querySelector(".modal-content");
        const isOutside = !modalContent.contains(event.target);
        if (event.target === modal && isOutside) {
            modal.style.display = "none";
        }
    });

    // Закриття по клавіші Escape (додатково)
    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            modal.style.display = "none";
        }
    });
});







// Файл product.html
const memoryFilters = document.querySelectorAll('.memory-filter');
const colorOptions = document.querySelectorAll('.color-option');
const productCards = document.querySelectorAll('.product-card');

// Функція для фільтрації товарів за вибраними значеннями пам'яті та кольору
function filterProducts() {
    const selectedMemory = [];
    const selectedColors = [];

    memoryFilters.forEach(filter => {
        if (filter.checked) {
            selectedMemory.push(filter.value);
        }
    });

    colorOptions.forEach(option => {
        if (option.classList.contains('active')) {
            selectedColors.push(option.getAttribute('data-color'));
        }
    });

    productCards.forEach(card => {
        const productName = card.getAttribute('data-name');
        const productColor = card.getAttribute('data-color');
        const productMemory = selectedMemory.some(memory => productName.includes(memory));
        const productMatchesColor = selectedColors.some(color => productColor.includes(color));

        // Показуємо/ховаємо картки залежно від наявності пам'яті та кольору
        if ((selectedMemory.length === 0 || productMemory) && (selectedColors.length === 0 || productMatchesColor)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Додавання активного класу до вибраних кольорів
colorOptions.forEach(option => {
    option.addEventListener('click', function () {
        option.classList.toggle('active');
        filterProducts();
    });
});

// Додаємо слухачів подій для фільтрів пам'яті
memoryFilters.forEach(filter => {
    filter.addEventListener('change', filterProducts);
});

// Фільтрація при завантаженні сторінки (якщо фільтри вже вибрані)
filterProducts();

// Пошук по назві товару
const searchInput = document.getElementById('searchInput');
searchInput.addEventListener('input', function () {
    const searchTerm = searchInput.value.toLowerCase();
    productCards.forEach(card => {
        const productName = card.getAttribute('data-name').toLowerCase();
        if (productName.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});





