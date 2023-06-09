import {moveLabel} from "./global.js";

const baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
const url = new URL('ajax.php', baseUrl);


export function addVendingToCustomerAttachEventListeners(container) {
    const customers = container.querySelectorAll('section .Customer_name');

    customers.forEach(customer => {
        customer.addEventListener('click', showContainerAddVending);
    });

    const addVendingSubmit = container.querySelector('.addVending');

    if (addVendingSubmit !== null) {
        addVendingSubmit.addEventListener('click', addVendingToCustomer);
    }

}

function addVendingToCustomer(event)
{
    event.preventDefault();

    const formElement = event.currentTarget.closest('[data-customer-id]');
    const id = formElement.dataset.customerId;

    let formData = new FormData(formElement);
    formData.append('context', 'addVendingToCustomer');
    formData.append('customer_id', id);

    if (formElement.checkValidity()) {
        fetch(url.toString(), {method: 'POST', body: formData})
            .then(response => response.text())
            .then(data => {
                const targetCustomerContainer = document.querySelector(`section[data-customer-id='${id}']`)
                refreshCustomer(targetCustomerContainer, data)
            })
            .then(() => {

                const containerAddVending = document.querySelector('.container_add_vending_form');
                containerAddVending.classList.toggle('hidden');
            })
    } else {
        const invalidFields = Array.from(formElement.elements).filter(element => !element.validity.valid);

        invalidFields.forEach(field => {
            field.classList.add("field_empty");
        });
    }

}

function showContainerAddVending(event)
{
    event.preventDefault();

    const targetCustomer = event.currentTarget.closest('[data-customer-id]');
    const id = targetCustomer.dataset.customerId;
    const companyName = targetCustomer.dataset.companyName;


    let data = new FormData();
    data.append('context', 'showContainerAddVending');
    data.append('customer_id', id);
    data.append('customer_company_name', companyName);

    fetch(url.toString(), {method: 'POST', body: data})
        .then(response => response.text())
        .then(data => {

            const containerAddVending = document.querySelector('.container_add_vending_form');
            replaceContainer(containerAddVending, data);
        })
        .then(() => {
            moveLabel();
            listenCloseButton();
        })
}

function refreshCustomer(container, data) {
    container.outerHTML = data;
    addVendingToCustomerAttachEventListeners(container);
}

function replaceContainer(container, data) {
    container.innerHTML = data;
    showCustomerContainer(container);
    addVendingToCustomerAttachEventListeners(container);
}

function listenCloseButton() {
    const close = document.querySelector('.closeAddVendingForm');
    const container = document.querySelector('.container_add_vending_form');
    close.addEventListener('click', (event) => {
        event.preventDefault();
        container.classList.toggle('hidden');
    });
}

function showCustomerContainer(container) {
    container.classList.remove('hidden');
}

const customerContainer = document.querySelector('.CustomerContainer');
addVendingToCustomerAttachEventListeners(customerContainer);