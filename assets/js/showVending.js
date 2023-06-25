import {vendingLocationAttachEventListeners} from './addBatchToVending.js';
import {handleImageSize} from "./handleImageSize.js";

import {toggleClass} from "./global.js";

const baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
const url = new URL('ajax.php', baseUrl);

const vendingContainer = document.querySelector('.vendingGrid');


export function vendingListAttachEventListeners() {

    const vendings = document.querySelectorAll('ul.vending');

    vendings.forEach(vending => {
        vending.addEventListener('click', handleClickVendingList);
    })
}
export function handleClickVendingList(event)
{
    const id = event.currentTarget.dataset.vendingId;

    const btnAddVending = document.querySelector('.btn_add_vending');
    const btnBackVendingToVendingList = document.querySelector('.btn_back_new_vending_to_vendingList');
    const sectionVendingList = document.querySelector('.vending_list_container');
    const elementName = event.currentTarget.querySelector('[data-name]');
    const name = elementName.dataset.name;

    const vendingTags = "Nom : " + name;

    let data = new FormData();
    data.append('context', 'vendingId');
    data.append('vending_id', id);
    data.append('vending_tags', vendingTags);

    fetch(url.toString(), {method: 'POST', body: data})
        .then( response => response.text())
        .then( data => {
            buildVendingContainer(data)
        })
        .then( () => {
            toggleClass(btnAddVending, token)
            toggleClass(sectionVendingList, token)
            toggleClass(btnBackVendingToVendingList, token)

            const vendings = document.querySelectorAll('ul.vending');

            vendings.forEach(vending => {
                vending.removeEventListener('click', handleClickVendingList);
            })
        })
}

function buildVending() {

}

const token = 'hidden';
function attachEventBackActionButton()
{
    const btnBackVendingToVendingList = document.querySelector('.btn_back_new_vending_to_vendingList');

    btnBackVendingToVendingList.addEventListener('click', backAction);
}

function backAction()
{
    const btnBackVendingToVendingList = document.querySelector('.btn_back_new_vending_to_vendingList');
    const sectionVendingList = document.querySelector('.vending_list_container');
    const btnAddVending = document.querySelector('.btn_add_vending');
    const sectionVending = document.querySelector('.vendingGrid');
    toggleClass(btnBackVendingToVendingList, token);
    toggleClass(sectionVendingList, token);
    toggleClass(btnAddVending, token);
    toggleClass(sectionVending, token);
    btnBackVendingToVendingList.removeEventListener('click', backAction);
    const vendings = document.querySelectorAll('ul.vending');

    vendings.forEach(vending => {
        vending.addEventListener('click', handleClickVendingList);
    })
}



// Fonction qui remplace un conteneur avec les données fournies
export function buildVendingContainer(data) {

    showVending(vendingContainer);
    vendingContainer.innerHTML = data;

    styleVending();

    attachEventBackActionButton();;
}

function styleVending() {
    const trays = document.querySelectorAll('ul.plateau');
    trays.forEach( tray => {

        const spirals = tray.querySelectorAll('li.spiral');
        const numberOfSpiral = spirals.length;

        tray.style.gridTemplateColumns = `repeat(${numberOfSpiral}, 1fr)`;

        const imgDir = "../assets/img/products/";

        spirals.forEach((spiral) => {
            const id = spiral.dataset.productBarcode;
            const prefix = 'VENLO_';
            const imageUrl = imgDir + prefix + id + '.jpg' ;
            const selector = '.batch_picture';

            handleImageSize(spiral, imageUrl, selector);

        });
    });

    vendingLocationAttachEventListeners(vendingContainer)
}

function showVending(container)
{
    container.classList.remove('hidden');
}


vendingListAttachEventListeners();
styleVending();