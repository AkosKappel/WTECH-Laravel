const decrement = (index) => {
    let inputField = document.getElementById(`product-${index}-quantity`);
    let form = document.getElementById(`quantity-${index}-form`);
    inputField.value = Math.max(parseInt(inputField.value) - 1, 1);
    form.submit();
}

const increment = (index) => {
    let inputField = document.getElementById(`product-${index}-quantity`);
    let form = document.getElementById(`quantity-${index}-form`);
    inputField.value = Math.min(parseInt(inputField.value) + 1, inputField.max);
    form.submit();
}
