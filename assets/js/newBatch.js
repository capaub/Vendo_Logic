import {toggleClass} from "./global.js";
import {StyleImageStockList} from "./styleImageStockList.js";
import {goodsOptionAttachEventListener} from "./changeBatchInfo.js";

let baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
let url = new URL('ajax.php', baseUrl);

let token = 'hidden';
let containerFormAddBatch = document.querySelector('.new_batch_form');

let formAddBatch = containerFormAddBatch.querySelector('.search_form');
let addBatchButton = document.querySelector('.btnAddBatch');

function addBatchButtonAttacheEventListener(addBatchButton) {
    let containerFormAddBatch = document.querySelector('.new_batch_form');

    addBatchButton.addEventListener('click', () => {

        toggleClass(containerFormAddBatch, token);

    })
}

function addBatchFormAttachEventListeners(formAddBatch) {
    let submitButton = formAddBatch.querySelector('input[type=submit]')


    submitButton.addEventListener('click', (event) => {
        event.preventDefault();

        newBatch(formAddBatch)
    })
}


function newBatch(formAddBatch) {


    let barcodeSibling = formAddBatch.querySelector('input[name=field_barcode]');
    let barcode = barcodeSibling.value;
    let quantitySibling = formAddBatch.querySelector('input[name=field_quantity]');
    let quantity = quantitySibling.value;
    let dlcSibling = formAddBatch.querySelector('input[name=field_dlc]');
    let dlc = dlcSibling.value;

    let formData = new FormData()
    formData.append('context', 'newBatch');
    formData.append('barcode', barcode);
    formData.append('quantity', quantity);
    formData.append('dlc', dlc);

    fetch(url.toString(), {method: 'POST', body: formData})
        .then( response => response.text() )
        .then( data => refreshStockList( data ) )
        .then( () => StyleImageStockList() )
        .then( () => {
            let addBatchButton = document.querySelector('.btnAddBatch');
            let batchSelect = document.querySelectorAll('select');
            let formAddBatch = document.querySelector('.search_form');
            goodsOptionAttachEventListener(batchSelect);
            addBatchButtonAttacheEventListener(addBatchButton);
            addBatchFormAttachEventListeners(formAddBatch);
            listenCloseButton();
        })
}

function refreshStockList(data){
    let containerStock = document.querySelector('.Main_stock');
    containerStock.outerHTML = data;
}

function listenCloseButton() {
    let close = document.querySelector('.closeNewBatchForm');

    let containerFormAddBatch = document.querySelector('.new_batch_form');

    close.addEventListener('click', (event) => {
        event.preventDefault();

        toggleClass(containerFormAddBatch, token);
    });
}

addBatchButtonAttacheEventListener(addBatchButton);
listenCloseButton();
addBatchFormAttachEventListeners(formAddBatch);