import {btnAddCustomerAttachEvent} from "./showNewCustomerForm.js";
import {attachEventListeners} from "./addVendingToCustomer.js";
import {moveLabel} from "./global.js";

let baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
let url = new URL('ajax.php', baseUrl);


function refreshMainBackToCustomers() {

    let main = document.querySelector('.Main');

    let formData = new FormData()
    formData.append('context', 'backToCustomers');

    fetch(url.toString(), {method: 'POST', body: formData})
        .then( response => response.text() )
        .then( data => main.outerHTML = data )
        .then( () => {
            let customerContainer = document.querySelector('.customerContainer');

            let btnAddCustomer = customerContainer.querySelector('.btnAddCustomer');
            btnAddCustomerAttachEvent(btnAddCustomer);
            attachEventListeners(customerContainer);
            })
}

let  handleClick = (event) => {
    event.preventDefault();

    let sectionFormNewCustomer = document.querySelector('.container_new_customer_form');
    let formNewCustomer = sectionFormNewCustomer.querySelector('.new_customer_form');

    newCustomer(formNewCustomer);
}

export function formNewCustomerAttachEventListeners(formNewCustomer) {
    moveLabel();

    let btnBackToCustomers = document.querySelector('.btnBackToCustomers');
    btnBackToCustomers.addEventListener('click', refreshMainBackToCustomers);

    let submitButton = formNewCustomer.querySelector('input[type=submit]');
    submitButton.addEventListener('click', handleClick);
}


function newCustomer(formNewCustomer) {


    let formData = new FormData(formNewCustomer)
    formData.append('context', 'newCustomer');

    let main = document.querySelector('.Main');

    if (formNewCustomer.checkValidity()) {
    fetch(url.toString(), {method: 'POST', body: formData})
        .then( response => response.text() )
        .then( data => main.outerHTML = data)
        .then( () => {

            let btnAddCustomer = document.querySelector('.btnAddCustomer');

            btnAddCustomerAttachEvent(btnAddCustomer)

            let customerContainer = document.querySelector('.customerContainer');
            attachEventListeners(customerContainer);
        })
} else {
    const elementsInvalides = Array.from(formNewCustomer.elements).filter(element => !element.validity.valid);

    // Parcours des éléments non valides
    elementsInvalides.forEach( element => {
        element.setAttribute('placeholder', 'Champs requis');
    });
}
}


// function refreshCustomerContainer(data){
//     sectionCustomer.innerHTML = data;
// }


