
function increment(index) {
    const input = document.getElementById(`product-${index}-quantity`);
    const maxQuantity = parseInt(input.getAttribute('max'));
    const currentValue = parseInt(input.value);
    
    if (currentValue < maxQuantity) {
        input.value = currentValue + 1;
        document.getElementById(`quantity-${index}-form`).submit();
    }
}

function decrement(index) {
    const input = document.getElementById(`product-${index}-quantity`);
    const currentValue = parseInt(input.value);
    
    if (currentValue > 1) {
        input.value = currentValue - 1;
        document.getElementById(`quantity-${index}-form`).submit();
    }
}
