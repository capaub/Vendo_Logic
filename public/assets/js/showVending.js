import {vendingLocationAttachEventListeners} from './addBatchToVending.js';
import {handleImageSize} from "./handleImageSize.js";

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
    const btnBackVendingToVendingList = document.querySelector('.btn_back_to_vendingList');
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
            btnAddVending.classList.toggle('hidden')
            sectionVendingList.classList.toggle('hidden')
            btnBackVendingToVendingList.classList.toggle('hidden')

            const vendings = document.querySelectorAll('ul.vending');

            vendings.forEach(vending => {
                vending.removeEventListener('click', handleClickVendingList);
            })
        })
}

function attachEventBackActionButton()
{
    const btnBackVendingToVendingList = document.querySelector('.btn_back_to_vendingList');

    btnBackVendingToVendingList.addEventListener('click', backAction);
}

function backAction()
{
    const btnBackVendingToVendingList = document.querySelector('.btn_back_to_vendingList');
    const sectionVendingList = document.querySelector('.vending_list_container');
    const btnAddVending = document.querySelector('.btn_add_vending');
    const sectionVending = document.querySelector('.vendingGrid');
    btnBackVendingToVendingList.classList.toggle('hidden');
    sectionVendingList.classList.toggle('hidden');
    btnAddVending.classList.toggle('hidden');
    sectionVending.classList.toggle('hidden');
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

    attachEventBackActionButton();
}

function styleVending() {
    const trays = document.querySelectorAll('ul.plateau');
    trays.forEach( tray => {

        const spirals = tray.querySelectorAll('li.spiral');
        const numberOfSpiral = spirals.length;

        tray.style.gridTemplateColumns = `repeat(${numberOfSpiral}, 1fr)`;

        const imgDir = "../public/assets/img/products/";

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