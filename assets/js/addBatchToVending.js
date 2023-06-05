import {buildVendingContainer} from './showVending.js';
import {moveLabel, toggleClass} from "./global.js";

const baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
const url = new URL('ajax.php', baseUrl);

export function VendingLocationAttachEventListeners(container) {

    let vendingLocation = container.querySelectorAll('li.spiral');

    vendingLocation.forEach(spiral => {
        spiral.addEventListener('click', (event) => {
            let target = event.currentTarget.querySelector('.locationIdentifier');
            let locationIdentifier = target.innerHTML;
            let vendingTags = target.dataset.vending;
            let vendingId = target.dataset.vendingId;

            let formAddBatch = document.querySelector('.add_batch_form');


            let data = new FormData();
            data.append('context', 'getBatch');
            data.append('location', locationIdentifier);
            data.append('vending_tags', vendingTags);
            data.append('vending_id', vendingId);

            fetch(url.toString(), {method: 'POST', body: data})
                .then( response => response.text() )
                .then( data => replaceContainer( formAddBatch, data) )
                .then( () => formAddBatch.setAttribute('data-vending-id', vendingId) )
                .then( () => showAddBatchForm() )
        });
    });
}

function listenCloseButton()
{
    let formAddBatchToVending = document.querySelector('.container_add_batch_form');

    let close = formAddBatchToVending.querySelector('.close');
    close.addEventListener('click', (event)=>{
        event.preventDefault();
        toggleClass(formAddBatchToVending,'hidden')
    })
}

function listenSubmitButton()
{
    let submit = document.querySelector('.addBatchSubmit');

    submit.addEventListener('click', (event) => {
        event.preventDefault();

        let form = submit.closest('[data-vending-id]');
        let vendingId = form.getAttribute('data-vending-id');

        let batchId = form.querySelector('select[name=field_batch]');
        let quantity = form.querySelector('input[name=field_quantity]');
        let location = form.querySelector('input[name=field_location]');

        let data = new FormData();

        data.append('context', 'addStockToVending');
        data.append('vending_id', vendingId);
        data.append('batch_id', batchId.value);
        data.append('quantity', quantity.value);
        data.append('location', location.value);

        if (form.checkValidity()) {
            fetch(url.toString(), {method: 'POST', body: data})
                .then(response => response.text())
                .then(() => refreshVendingGrid(vendingId))
                .then(() => hideAddBatchForm())
        } else {
            const elementsInvalides = Array.from(form.elements).filter(element => !element.validity.valid);

            // Parcours des éléments non valides
            elementsInvalides.forEach(function(element) {
                element.setAttribute('placeholder', 'Champs requis');
            });
        }
    });
}

function refreshVendingGrid(id) {

        let data = new FormData();
        data.append('context', 'vendingId');
        data.append('vending_id', id);

        fetch(url.toString(), {method: 'POST', body: data})
            .then( response => response.text())
            .then( data => buildVendingContainer(data))

}

function replaceContainer(container, data){
    container.innerHTML = data;
}

function showAddBatchForm()
{
    let container = document.querySelector('.container_add_batch_form');
    container.classList.remove('hidden');
    listenCloseButton();
    listenSubmitButton();
    moveLabel();
}

function hideAddBatchForm()
{
    let container = document.querySelector('.container_add_batch_form');
    container.classList.add('hidden');
}