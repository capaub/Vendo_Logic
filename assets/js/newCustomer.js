import {btnAddCustomerAttachEvent} from "./showNewCustomerForm.js";
import {addVendingToCustomerAttachEventListeners} from "./addVendingToCustomer.js";
import {moveLabel} from "./global.js";
import {sortCustomers} from "./sortCustomer.js";
import {attachEventListenerCustomerVending} from "./generateCustomerVending.js";

const baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
const url = new URL('ajax.php', baseUrl);


function refreshMainBackToCustomers() {

    const main = document.querySelector('.Main');

    let formData = new FormData()
    formData.append('context', 'backToCustomers');

    fetch(url.toString(), {method: 'POST', body: formData})
        .then(response => response.text())
        .then(data => main.outerHTML = data)
        .then(() => {
            const customerContainer = document.querySelector('.CustomerContainer');

            const btnAddCustomer = customerContainer.querySelector('.btnAddCustomer');
            btnAddCustomerAttachEvent(btnAddCustomer);
            addVendingToCustomerAttachEventListeners(customerContainer);
            sortCustomers();
            attachEventListenerCustomerVending();
            // addVendingToCustomerAttachEventListeners(customerContainer);
        })
}

const handleClick = (event) => {
    event.preventDefault();

    const sectionFormNewCustomer = document.querySelector('.container_new_customer_form');
    const formNewCustomer = sectionFormNewCustomer.querySelector('.new_customer_form');

    newCustomer(formNewCustomer);
}

export function formNewCustomerAttachEventListeners(formNewCustomer) {
    moveLabel();

    const btnBackToCustomers = document.querySelector('.btnBackToCustomers');
    btnBackToCustomers.addEventListener('click', refreshMainBackToCustomers);

    const submitButton = formNewCustomer.querySelector('input[type=submit]');
    submitButton.addEventListener('click', handleClick);
}


function newCustomer(formNewCustomer)
{
    let formData = new FormData(formNewCustomer)
    formData.append('context', 'newCustomer');

    const main = document.querySelector('.Main');

    if (formNewCustomer.checkValidity()) {
        fetch(url.toString(), {method: 'POST', body: formData})
            .then(response => response.text())
            .then(data => main.outerHTML = data)
            .then(() => {

                const btnAddCustomer = document.querySelector('.btnAddCustomer');

                btnAddCustomerAttachEvent(btnAddCustomer)

                const customerContainer = document.querySelector('.CustomerContainer');
                addVendingToCustomerAttachEventListeners(customerContainer);
            })
    } else {
        const invalidFields = Array.from(formNewCustomer.elements).filter(element => !element.validity.valid);

        invalidFields.forEach(field => {
            field.classList.add("field_empty");
        });
    }
}


// function refreshCustomerContainer(data){
//     sectionCustomer.innerHTML = data;
// }


