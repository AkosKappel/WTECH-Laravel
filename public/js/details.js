// changing quantity field
function decrement(e) {
    let priceStr = productPrice.innerText;
    priceStr = priceStr.replace(' ', '').substring(0, priceStr.length - 1);
    let quantity = Number(quantityField.value);
    if (quantity > quantityField.min) {
        quantity--;
    }
    totalPrice.innerText = `${(quantity * parseFloat(priceStr.replace(',', '.'))).toFixed(2)} €`.replace('.', ',');
    quantityField.value = quantity;
}

function increment(e) {
    let priceStr = productPrice.innerText;
    priceStr = priceStr.replace(' ', '').substring(0, priceStr.length - 1);
    let quantity = Number(quantityField.value);
    if (quantity < quantityField.max) {
        quantity++;
    }
    totalPrice.innerText = `${(quantity * parseFloat(priceStr.replace(',', '.'))).toFixed(2)} €`.replace('.', ',');
    quantityField.value = quantity;
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


nextImageBtn.addEventListener('click', showNextImage);
prevImageBtn.addEventListener('click', showPrevImage);


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

