function decrement(e) {
    const btn = e.target.parentNode.parentElement.querySelector('button[data-action="decrement"]');
    const target = btn.nextElementSibling;
    let value = Number(target.value);
    value > 1 ? value-- : value;
    target.value = value;
    total.innerText = `${(value * parseFloat(solo.innerText)).toFixed(2)} €`;
}

function increment(e) {
    const btn = e.target.parentNode.parentElement.querySelector('button[data-action="decrement"]');
    const target = btn.nextElementSibling;
    let value = Number(target.value);
    value++;
    target.value = value;
    total.innerText = `${(value * parseFloat(solo.innerText)).toFixed(2)} €`;
}

const decrementButtons = document.querySelectorAll(`button[data-action="decrement"]`);

const incrementButtons = document.querySelectorAll(`button[data-action="increment"]`);

const total = document.getElementById('total-price');
const solo = document.getElementById('single-price');

decrementButtons.forEach(btn => {
    btn.addEventListener('click', decrement);
});

incrementButtons.forEach(btn => {
    btn.addEventListener('click', increment);
});
