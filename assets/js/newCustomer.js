import {btnAddCustomerAttachEvent} from "./showNewCustomerForm.js";

let baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
let url = new URL('ajax.php', baseUrl);

document.addEventListener('load', () => {
    let btnBackToCustomers = document.querySelector('.btnBackToCustomers');

    btnBackToCustomers.addEventListener('click', () => {

        refreshMainBackToCustomers();

    })
})

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
            })
}

let  handleClick = (event) => {
    event.preventDefault();

    let sectionFormNewCustomer = document.querySelector('.new_customer_section');
    let formNewCustomer = sectionFormNewCustomer.querySelector('.new_customer_form');

    newCustomer(formNewCustomer);
}

export function formNewCustomerAttachEventListeners(formNewCustomer) {

    let btnBackToCustomers = document.querySelector('.btnBackToCustomers');
    btnBackToCustomers.addEventListener('click', () => {

        refreshMainBackToCustomers();

    })

    let submitButton = formNewCustomer.querySelector('input[type=submit]');
    submitButton.addEventListener('click', handleClick);
}


function newCustomer(formNewCustomer) {


    let companySiretSibling = formNewCustomer.querySelector('input[name=field_company_siret]');
    let companySiret = companySiretSibling.value;

    let companyNameSibling = formNewCustomer.querySelector('input[name=field_company_name]');
    let companyName = companyNameSibling.value;

    let countrySibling = formNewCustomer.querySelector('input[name=field_country]');
    let country = countrySibling.value;

    let citySibling = formNewCustomer.querySelector('input[name=field_city]');
    let city = citySibling.value;

    let postalCodeSibling = formNewCustomer.querySelector('input[name=field_postal_code]');
    let postalCode = postalCodeSibling.value;

    let streetNameSibling = formNewCustomer.querySelector('input[name=field_street_name]');
    let streetName = streetNameSibling.value;

    let emailSibling = formNewCustomer.querySelector('input[name=field_email]');
    let email = emailSibling.value;

    let phoneSibling = formNewCustomer.querySelector('input[name=field_phone]');
    let phone = phoneSibling.value;

    let firstnameSibling = formNewCustomer.querySelector('input[name=field_firstname]');
    let firstname = firstnameSibling.value;

    let lastnameSibling = formNewCustomer.querySelector('input[name=field_lastname]');
    let lastname = lastnameSibling.value;


    let formData = new FormData()
    formData.append('context', 'newCustomer');
    formData.append('field_company_siret', companySiret);
    formData.append('field_company_name', companyName);
    formData.append('field_country', country);
    formData.append('field_city', city);
    formData.append('field_postal_code', postalCode);
    formData.append('field_street_name', streetName);
    formData.append('field_email', email);
    formData.append('field_phone', phone);
    formData.append('field_firstname', firstname);
    formData.append('field_lastname', lastname);

    let main = document.querySelector('.Main');

    fetch(url.toString(), {method: 'POST', body: formData})
        .then( response => response.text() )
        .then( data => main.outerHTML = data)
        .then( () => {

            let btnAddCustomer = document.querySelector('.btnAddCustomer');

            btnAddCustomerAttachEvent(btnAddCustomer)

        })
}


function refreshCustomerContainer(data){
    sectionCustomer.innerHTML = data;
}