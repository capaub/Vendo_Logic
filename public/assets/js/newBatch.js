import {listenInputNumber} from "./global.js";
import {StyleImageStockList} from "./styleImageStockList.js";
import {goodsOptionAttachEventListener} from "./changeBatchInfo.js";

const baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
const url = new URL('ajax.php', baseUrl);

const containerFormAddBatch = document.querySelector('.container_new_batch_form');
const formAddBatch = containerFormAddBatch.querySelector('.search_form');
const addBatchButton = document.querySelector('.btnAddBatch');
let eventListenerAttached = false;

function addBatchButtonAttacheEventListener(addBatchButton) {

    if (eventListenerAttached) {
        addBatchButton.removeEventListener('click', handleClick)
        eventListenerAttached = false;
    }
        addBatchButton.addEventListener('click', handleClick)
}

function handleClick() {
    containerFormAddBatch.classList.toggle('hidden');
    eventListenerAttached = true;
}

function addBatchFormAttachEventListeners(formAddBatch) {
    listenInputNumber();
    const submitButton = formAddBatch.querySelector('input[type=submit]')

    submitButton.addEventListener('click', (event) => {
        event.preventDefault();
        newBatch(formAddBatch)
    })
}


function newBatch(formAddBatch) {

    const barcodeSibling = formAddBatch.querySelector('input[name=field_barcode]');
    const barcode = barcodeSibling.value;
    const quantitySibling = formAddBatch.querySelector('input[name=field_quantity]');
    const quantity = quantitySibling.value;
    const dlcSibling = formAddBatch.querySelector('input[name=field_dlc]');
    const dlc = dlcSibling.value;

    let formData = new FormData()
    formData.append('context', 'newBatch');
    formData.append('barcode', barcode);
    formData.append('quantity', quantity);
    formData.append('dlc', dlc);

    if (formAddBatch.checkValidity()) {
        fetch(url.toString(), {method: 'POST', body: formData})
            .then(response => response.text())
            .then(data => refreshStockList(data))
            .then(() => {
                const tableHeader = document.querySelector('.grid_container');
                const lengthHeader = document.querySelectorAll('.colHeader');
                const numberOfCol = lengthHeader.length;

                tableHeader.style.gridTemplateColumns = `repeat(${numberOfCol}, 1fr)`;
                StyleImageStockList();
            })
            .then(() => {
                const addBatchButton = document.querySelector('.btnAddBatch');
                const batchSelect = document.querySelectorAll('.select_dlc_batch');
                const formAddBatch = document.querySelector('.search_form');
                goodsOptionAttachEventListener(batchSelect);
                addBatchButtonAttacheEventListener(addBatchButton);
                addBatchFormAttachEventListeners(formAddBatch);
                listenCloseButton();
            })
    } else {
        const invalidFields = Array.from(formAddBatch.elements).filter(element => !element.validity.valid);

        invalidFields.forEach(field => {
            field.classList.add("field_empty");
        });
    }
}

function refreshStockList(data) {
    const containerStock = document.querySelector('.Main_stock');
    containerStock.outerHTML = data;
}

function listenCloseButton() {
    const close = document.querySelector('.closeNewBatchForm');

    close.addEventListener('click', (event) => {
        event.preventDefault();

        containerFormAddBatch.classList.toggle('hidden');
    });
}

addBatchButtonAttacheEventListener(addBatchButton);
listenCloseButton();
addBatchFormAttachEventListeners(formAddBatch);
