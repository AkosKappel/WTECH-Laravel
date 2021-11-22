const icon = document.getElementById('burger-icon');
const filters = document.getElementById('filters');

icon.addEventListener('click', () => {
    if (filters.classList.contains('hidden')) {
        filters.classList.remove('hidden');
    } else {
        filters.classList.add('hidden');
    }
});

// const select = document.getElementById('sort');
// select.addEventListener('change', function(){
//     const selection = select.options[select.selectedIndex].value;
//     if (selection === 'asc')
//         select.options[1].selected = 'selected';
//     else
//         select.options[0].selected = 'selected';
//     this.form.submit();
// }, false);
//
// const handleSelect = () => {
//     const select = document.getElementById('sort');
//     const queryString = window.location.search;
//     const urlParams = new URLSearchParams(queryString);
//     if(urlParams.has('sort')){
//         const sort = urlParams.get('sort')
//         if (sort === 'asc')
//             select.options[1].selected = 'selected';
//         else
//             select.options[0].selected = 'selected';
//     }
// }
//
// window.addEventListener("load", function(){
//     handleSelect();
// });
