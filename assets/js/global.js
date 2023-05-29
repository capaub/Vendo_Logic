let listenBurger = document.querySelector('.Header_burger');
let displayLinks = document.querySelector('.Sidebar');
let burgerActiveBlur = document.querySelector('.Main');
let listenMoreInfos = document.querySelectorAll('h3 span');
let displayInfos = document.querySelector('.Customer_container_infos')
let burgerAnim = document.querySelector('.Icon');

listenBurger.addEventListener('click', function () {
    displayLinks.classList.toggle('active');
    burgerActiveBlur.classList.toggle('activeBlur');
})

listenMoreInfos.forEach(span =>{
    span.addEventListener('click', function (e) {
        let targetInfo = e.target.parentNode.nextElementSibling.children[1];
        targetInfo.classList.toggle('active');
    });
})

burgerAnim.addEventListener('click',function () {
    if(this.classList.contains('isOpened')){
        this.classList.replace(
            'isOpened',
            'isClosed');
    }else{
        this.classList.replace(
            'isClosed',
            'isOpened');
    }
})

const grid = document.querySelectorAll('.grid_container, .list_container');
grid.forEach(row => {
    const fields = row.querySelectorAll('li');
    const numberOfColumns = fields.length;
    row.style.gridTemplateColumns = `repeat(${numberOfColumns}, 1fr)`;
})


export function toggleClass(elements, token)
{
    elements.classList.toggle(token);
}