const icon = document.getElementById('burger-icon');
const filters = document.getElementById('filters');

icon.addEventListener('click', () => {
    if (filters.classList.contains('hidden')) {
        filters.classList.remove('hidden');
    } else {
        filters.classList.add('hidden');
    }
});

const select = document.getElementById('sort');
select.addEventListener('change', function(){
    const selection = select.options[select.selectedIndex].value;
    if (selection === 'asc')
        select.options[1].selected = 'selected';
    else
        select.options[0].selected = 'selected';
    this.form.submit();
}, false);

const handleSelect = urlParams => {
    const select = document.getElementById('sort');
    if(urlParams.has('sort')){
        const sort = urlParams.get('sort')
        if (sort === 'asc')
            select.options[1].selected = 'selected';
        else
            select.options[0].selected = 'selected';
    }
}

const paramsToObject = entries => {
    const result = [];
    for(const [key, value] of entries) {
        result.push(key);
    }
    return result;
}

const handleFilters = urlParams => {
    const entries = urlParams.entries();
    const params = paramsToObject(entries);
    let brandSelects = document.getElementsByClassName("brand-select");
    for(let i = 0; i < brandSelects.length; i++){
        if(params.includes(brandSelects[i].getAttribute('name'))) {
            brandSelects[i].checked = true;
        }
    }
    let colorSelects = document.getElementsByClassName("color-select");
    for(let i = 0; i < colorSelects.length; i++){
        if(params.includes(colorSelects[i].getAttribute('name'))) {
            colorSelects[i].checked = true;
        }
    }
}

const handlePrice = urlParams => {
    const minPriceElement = document.getElementById('min-price');
    const maxPriceElement = document.getElementById('max-price');
    const minPrice = urlParams.get('min-price');
    const maxPrice = urlParams.get('max-price');

    if(minPrice)
        minPriceElement.value = parseFloat(minPrice);

    if(maxPrice)
        maxPriceElement.value = parseFloat(maxPrice);
}

window.addEventListener("load", function(){
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    handleSelect(urlParams);
    handleFilters(urlParams);
    handlePrice(urlParams);
});
