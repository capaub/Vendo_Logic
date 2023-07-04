import {formNewCustomerAttachEventListeners} from "./newCustomer.js";

let baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
let url = new URL('ajax.php', baseUrl);

let customerContainer = document.querySelector('.customerContainer');

let btnAddCustomer = customerContainer.querySelector('.btnAddCustomer');
export function btnAddCustomerAttachEvent(btnAddCustomer) {
    btnAddCustomer.addEventListener('click', () => {

        refreshMainForAddCustomerForm();

    })
}

export function refreshMainForAddCustomerForm() {

    let main = document.querySelector('.Main');

    let formData = new FormData()
    formData.append('context', 'newCustomer');

    fetch(url.toString(), {method: 'POST', body: formData})
        .then( response => response.text() )
        .then( data => main.outerHTML = data )
        .then( () => {
            let formNewCustomer = document.querySelector('.new_customer_form')
            formNewCustomerAttachEventListeners(formNewCustomer)
        })
}

btnAddCustomerAttachEvent(btnAddCustomer);