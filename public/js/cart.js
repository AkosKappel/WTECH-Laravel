// Quantity changes on the cart page: sent in the background and applied in place, so the page does not reload.
// Quick clicks are merged into one request; if the request fails the page reloads to show the real state.
const pending = new Map();

function clamp(input, value) {
    const max = parseInt(input.getAttribute('max'));
    return Math.min(Math.max(value || 1, 1), max);
}

function send(form) {
    clearTimeout(pending.get(form));
    pending.set(form, setTimeout(function () {
        const input = form.querySelector('input[name="product_quantity"]');
        const row = form.closest('[data-cart-row]');
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        }).then(function (response) {
            if (!response.ok) throw new Error(response.status);
            return response.json();
        }).then(function (data) {
            input.value = data.qty;
            row.querySelector('[data-item-total]').textContent = data.itemTotal;
            document.querySelector('[data-cart-total]').textContent = data.total;
            document.querySelectorAll('[data-cart-count]').forEach(function (badge) { badge.textContent = data.count; });
        }).catch(function () {
            window.location.reload();
        });
    }, 300));
}

function change(index, delta) {
    const input = document.getElementById(`product-${index}-quantity`);
    const value = clamp(input, parseInt(input.value) + delta);
    if (value !== parseInt(input.value)) {
        input.value = value;
        send(input.form);
    }
}

function increment(index) {
    change(index, 1);
}

function decrement(index) {
    change(index, -1);
}

document.querySelectorAll('[data-quantity-form]').forEach(function (form) {
    const input = form.querySelector('input[name="product_quantity"]');
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        input.value = clamp(input, parseInt(input.value));
        send(form);
    });
    input.addEventListener('change', function () {
        input.value = clamp(input, parseInt(input.value));
        send(form);
    });
});
