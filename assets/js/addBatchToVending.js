import {buildVendingContainer} from './showVending.js';
import {toggleClass} from "./global.js";

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

            let formAddBatch = document.querySelector('.batch_form');


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
    let sectionAddBatchToVending = document.querySelector('.addBatchToVending');

    let close = sectionAddBatchToVending.querySelector('.close');
    close.addEventListener('click', (event)=>{
        event.preventDefault();
        toggleClass(sectionAddBatchToVending,'hidden')
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

        // let vendingListContainer = document.querySelector('.vendingListContainer');


        fetch(url.toString(), {method: 'POST', body: data})
            .then( response => response.text() )
            .then( () => refreshVendingGrid(vendingId) )
            .then( () => hideAddBatchForm() )
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
    let container = document.querySelector('.addBatchToVending');
    container.classList.remove('hidden');
    listenCloseButton();
    listenSubmitButton();
}

function hideAddBatchForm()
{
    let container = document.querySelector('.addBatchToVending');
    container.classList.add('hidden');
}