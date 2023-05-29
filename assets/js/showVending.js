import {VendingLocationAttachEventListeners} from './addBatchToVending.js';
import {handleImageSize} from "./handleImageSize.js";

import {toggleClass} from "./global.js";

let baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
let url = new URL('ajax.php', baseUrl);

let vendingContainer = document.querySelector('.vendingGrid');


export function vendingListAttachEventListeners(vendingListContainer) {

    let vendings = vendingListContainer.querySelectorAll('ul.vending');

    vendings.forEach(vending => {
        vending.addEventListener('click', (event) => {
            let id = event.currentTarget.dataset.vendingId;

            let elementName = event.currentTarget.querySelector('[data-name]');
            let name = elementName.dataset.name;

            let vendingTags = "Nom : " + name;

            let data = new FormData();
            data.append('context', 'vendingId');
            data.append('vending_id', id);
            data.append('vending_tags', vendingTags);

            fetch(url.toString(), {method: 'POST', body: data})
                .then( response => response.text())
                .then( data => buildVendingContainer(data))
                .then( () => toggleClass(sectionBackButton, token))
                .then( () => toggleClass(sectionVendingList, token))

        });
    })
}

let token = 'hidden';
function attachEventBackActionButton(sectionBackButton, sectionVendingList, sectionVending)
{
    let btnBackToVendingList = document.querySelector('.btnBackToVendingList');

    btnBackToVendingList.addEventListener('click', () => {
        toggleClass(sectionBackButton, token);
        toggleClass(sectionVendingList, token);
        toggleClass(sectionVending, token);
    })
}





// Fonction qui remplace un conteneur avec les données fournies
export function buildVendingContainer(data) {


    showVending(vendingContainer);
    vendingContainer.innerHTML = data;

    styleVending();


    VendingLocationAttachEventListeners(vendingContainer);
}

function styleVending() {
    const trays = vendingContainer.querySelectorAll('ul.plateau');
    trays.forEach( tray => {

        const spirals = tray.querySelectorAll('li.spiral');
        const numberOfSpiral = spirals.length;

        tray.style.gridTemplateColumns = `repeat(${numberOfSpiral}, 1fr)`;

        const imgDir = "../assets/img/products/";

        spirals.forEach((spiral) => {
            const id = spiral.dataset.productBarcode;
            const prefix = 'VENLO_';
            const imageUrl = imgDir + prefix + id + '.jpg' ;
            const selector = '.batchPicture';

            handleImageSize(spiral, imageUrl, selector);

        });
    });


}

function showVending(container)
{
    container.classList.remove('hidden');
}

let sectionVendingList = document.querySelector('.vendingListContainer');
let sectionBackButton = document.querySelector('.btnBackToVendingList');
let sectionVending = document.querySelector('.vendingGrid');

// Attache les écouteurs d'événements initiaux au document
vendingListAttachEventListeners(sectionVendingList);


// let sectionVendingList = vendingListContainer.parentNode;
// let sectionBackButton = sectionVendingList.previousElementSibling;
// let sectionVending = sectionVendingList.nextElementSibling;

console.log(sectionVendingList)
console.log(sectionBackButton)
console.log(sectionVending)

attachEventBackActionButton(sectionBackButton, sectionVendingList, sectionVending);
styleVending();