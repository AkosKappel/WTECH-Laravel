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
    const options = document.getElementsByClassName('sort-option');
    for (const option of options) {
        option.classList.toggle('selected');
        // option.selected = !option.selected;
        console.log(option);
    }
    this.form.submit();
}, false);
