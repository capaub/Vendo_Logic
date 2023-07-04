import { buildVendingContainer } from './showVending.js';
import { moveLabel, toggleClass } from "./global.js";

const baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
const url = new URL('ajax.php', baseUrl);

                    export function vendingLocationAttachEventListeners(container) {

                        const vendingLocation = container.querySelectorAll('li.spiral');

                        vendingLocation.forEach(spiral => {
                            spiral.addEventListener('click', handleClickVendingLocation);
                        });
                    }

function handleClickVendingLocation(event)
{
    const target = event.currentTarget.querySelector('.location_identifier');
    const locationIdentifier = target.innerHTML;
    const vendingTags = target.dataset.vending;
    const vendingId = target.dataset.vendingId;

    const formAddBatch = document.querySelector('.add_batch_form');

    let data = new FormData();
    data.append('context', 'getBatch');
    data.append('location', locationIdentifier);
    data.append('vending_tags', vendingTags);
    data.append('vending_id', vendingId);

    fetch(url.toString(), {method: 'POST', body: data})
        .then( response => response.text() )
        .then( data => replaceContainer( formAddBatch, data) )
        .then( () => formAddBatch.setAttribute('data-vending-id', vendingId) )
        .then( () => {
            const container = document.querySelector('.container_add_batch_form');
            showAddBatchForm(container)
        } )
}

function listenCloseButton(container)
{
    const close = container.querySelector('.close');
    close.addEventListener('click', handleClickCloseBtn);
}

function handleClickCloseBtn(event)
{
    const container = document.querySelector('.container_add_batch_form');
    event.preventDefault();
    toggleClass(container,'hidden')
}

function listenSubmitButton()
{
    const submit = document.querySelector('.add_batch_submit');

    submit.addEventListener('click', handleClickSubmitBtn);
}

function handleClickSubmitBtn(event) {
    event.preventDefault();

    const form = event.currentTarget.closest('[data-vending-id]');
    const vendingId = form.getAttribute('data-vending-id');

    const batchId = form.querySelector('select[name=field_batch]');
    const quantity = form.querySelector('input[name=field_quantity]');
    const location = form.querySelector('input[name=field_location]');

    let data = new FormData();

    data.append('context', 'addStockToVending');
    data.append('vending_id', vendingId);
    data.append('batch_id', batchId.value);
    data.append('quantity', quantity.value);
    data.append('location', location.value);

    if (form.checkValidity()) {
        fetch(url.toString(), {method: 'POST', body: data})
            .then(response => response.text() )
            .then(() => refreshVendingGrid(vendingId))
            .then(() => hideAddBatchForm())
    } else {
        const invalidFields = Array.from(form.elements).filter(element => !element.validity.valid);

        invalidFields.forEach(field => {
            field.classList.add("field_empty");
        });
    }
}

function refreshVendingGrid(id) {

        let data = new FormData();
        data.append('context', 'vendingId');
        data.append('vending_id', id);

        fetch(url.toString(), {method: 'POST', body: data} )
            .then( response => response.text() )
            .then( data => buildVendingContainer(data) )

}

function replaceContainer(container, data){
    container.innerHTML = data;
}

function showAddBatchForm(container)
{
    toggleClass(container, 'hidden');
    listenCloseButton(container);
    listenSubmitButton();
    moveLabel();
}

function hideAddBatchForm()
{
    const container = document.querySelector('.container_add_batch_form');
    container.classList.add('hidden');
}