// changing quantity field
// same format as formattedPrice() in app/toolkit.php
const priceFormat = new Intl.NumberFormat(document.documentElement.lang, { style: 'currency', currency: 'EUR' });

function showTotal(quantity) {
    totalPrice.innerText = priceFormat.format(quantity * Number(productPrice.dataset.price));
    quantityField.value = quantity;
}

function decrement(e) {
    const quantity = Number(quantityField.value);
    showTotal(quantity > quantityField.min ? quantity - 1 : quantity);
}

function increment(e) {
    const quantity = Number(quantityField.value);
    showTotal(quantity < quantityField.max ? quantity + 1 : quantity);
}


const decrementButtons = document.querySelectorAll(`button[data-action="decrement"]`);
const incrementButtons = document.querySelectorAll(`button[data-action="increment"]`);
const quantityField = document.getElementById('product-quantity');

const totalPrice = document.getElementById('total-price');
const productPrice = document.getElementById('product-price');


decrementButtons.forEach(btn => {
    btn.addEventListener('click', decrement);
});

incrementButtons.forEach(btn => {
    btn.addEventListener('click', increment);
});




// switching between product images
const mainImage = document.querySelector('#mainImage');
const allImages = document.querySelectorAll('.productImage');

const nextImageBtn = document.getElementById('next-img-btn');
const prevImageBtn = document.getElementById('prev-img-btn');

let imgIndex = 0;


nextImageBtn?.addEventListener('click', showNextImage);
prevImageBtn?.addEventListener('click', showPrevImage);


function showNextImage() {
    imgIndex = (++imgIndex) % allImages.length;
    mainImage.src = allImages[imgIndex].src;
    mainImage.alt = allImages[imgIndex].alt;
}

function showPrevImage() {
    imgIndex = ((--imgIndex) % allImages.length + allImages.length) % allImages.length;
    mainImage.src = allImages[imgIndex].src;
    mainImage.alt = allImages[imgIndex].alt;
}

