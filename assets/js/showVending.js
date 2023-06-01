import {VendingLocationAttachEventListeners} from './addBatchToVending.js';
import {handleImageSize} from "./handleImageSize.js";

import {toggleClass} from "./global.js";

let baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
let url = new URL('ajax.php', baseUrl);

let vendingContainer = document.querySelector('.vendingGrid');


export function vendingListAttachEventListeners() {

    let vendings = document.querySelectorAll('ul.vending');

    vendings.forEach(vending => {
        vending.addEventListener('click', handleClickVendingList);
    })
}
export let handleClickVendingList = (event) => {
    let id = event.currentTarget.dataset.vendingId;

    let btnAddVending = document.querySelector('.btnAddVending');
    let btnBackVendingToVendingList = document.querySelector('.btnBackVendingToVendingList');
    let sectionVendingList = document.querySelector('.vendingListContainer');
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
        .then( () => {
            toggleClass(btnAddVending, token)
            toggleClass(sectionVendingList, token)
            toggleClass(btnBackVendingToVendingList, token)

            let vendings = document.querySelectorAll('ul.vending');

            vendings.forEach(vending => {
                vending.removeEventListener('click', handleClickVendingList);
            })
        })
}

function buildVending() {

}

let token = 'hidden';
function attachEventBackActionButton()
{
    let btnBackVendingToVendingList = document.querySelector('.btnBackVendingToVendingList');

    btnBackVendingToVendingList.addEventListener('click', backAction);
}

let backAction = () => {
    let btnBackVendingToVendingList = document.querySelector('.btnBackVendingToVendingList');
    let sectionVendingList = document.querySelector('.vendingListContainer');
    let btnAddVending = document.querySelector('.btnAddVending');
    let sectionVending = document.querySelector('.vendingGrid');
    toggleClass(btnBackVendingToVendingList, token);
    toggleClass(sectionVendingList, token);
    toggleClass(sectionVending, token);
    toggleClass(btnAddVending, token);
    btnBackVendingToVendingList.removeEventListener('click', backAction);
    let vendings = document.querySelectorAll('ul.vending');

    vendings.forEach(vending => {
        vending.addEventListener('click', handleClickVendingList);
    })
}



// Fonction qui remplace un conteneur avec les données fournies
export function buildVendingContainer(data) {


    showVending(vendingContainer);
    vendingContainer.innerHTML = data;

    styleVending();

    attachEventBackActionButton();
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

// Attache les écouteurs d'événements initiaux au document
vendingListAttachEventListeners();



attachEventBackActionButton();
styleVending();