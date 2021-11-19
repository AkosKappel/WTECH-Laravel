const icon = document.getElementById('burger-icon');
const filters = document.getElementById('filters');

icon.addEventListener('click', () => {
    if (filters.classList.contains('hidden')) {
        filters.classList.remove('hidden');
    } else {
        filters.classList.add('hidden');
    }
});

let select = document.getElementById('sort');
select.addEventListener('change', function(){
    this.form.submit();
}, false);
