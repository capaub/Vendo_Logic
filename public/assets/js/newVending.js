import { buildGridTemplateColumns, moveLabel, toggleClass } from "./global.js";
import { handleClickVendingList } from "./showVending.js";

const baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
const url = new URL('ajax.php', baseUrl);

function handleClickBtnBackToVendingList() {

    const newVendingForm = document.querySelector('.new_vending_form');
    const btnAddVending = document.querySelector('.btn_add_vending');
    const btnBackAddVendingToVendingList = document.querySelector('.btn_back_add_batch_vending_to_vendingList');

    toggleClass(btnAddVending, 'hidden');
    toggleClass(btnBackAddVendingToVendingList, 'hidden');
    toggleClass(newVendingForm, 'hidden');

    btnAddVending.addEventListener('click', handleClickBtnAddVending);

    const vendings = document.querySelectorAll('ul.vending');

    vendings.forEach(vending => {
        vending.addEventListener('click', handleClickVendingList);
    })

    btnBackAddVendingToVendingList.removeEventListener('click', handleClickBtnBackToVendingList);

}

function handleClickCloseButton(event)
{
    event.preventDefault();

    const containerNewVendingForm = document.querySelector('.container_new_vending_form');
    const btnAddVending = document.querySelector('.btn_add_vending');
    const btnBackAddVendingToVendingList = document.querySelector('.btn_back_add_batch_vending_to_vendingList');

    toggleClass(containerNewVendingForm, 'hidden');
    toggleClass(btnAddVending, 'hidden');
    toggleClass(btnBackAddVendingToVendingList, 'hidden');

    btnAddVending.addEventListener('click', handleClickBtnAddVending);
    btnBackAddVendingToVendingList.removeEventListener('click', handleClickBtnBackToVendingList);

    const close = document.querySelector('.close_new_vending_form');
    close.removeEventListener('click', handleClickCloseButton);

    const vendings = document.querySelectorAll('ul.vending');
    vendings.forEach(vending => {
        vending.addEventListener('click', handleClickVendingList);
    })
}

function handleClickBtnAddVending() {

    moveLabel();

    const containerNewVendingForm = document.querySelector('.container_new_vending_form');
    const btnAddVending = document.querySelector('.btn_add_vending');
    const btnBackAddVendingToVendingList = document.querySelector('.btn_back_add_batch_vending_to_vendingList');
    const close = document.querySelector('.close_new_vending_form');

    close.addEventListener('click', handleClickCloseButton);

    toggleClass(btnAddVending, 'hidden');
    toggleClass(btnBackAddVendingToVendingList, 'hidden');
    toggleClass(containerNewVendingForm, 'hidden');

    btnAddVending.removeEventListener('click', handleClickBtnAddVending);
    btnBackAddVendingToVendingList.addEventListener('click', handleClickBtnBackToVendingList);

    const vendings = document.querySelectorAll('ul.vending');

    vendings.forEach(vending => {
        vending.removeEventListener('click', handleClickVendingList);
    })

    const btnSubmitNewVending = document.querySelector('.new_vending_submit');
    btnSubmitNewVending.addEventListener('click', handleClickSubmitNewVending);
}

function handleClickSubmitNewVending(event)
{
    event.preventDefault();
    const newVendingForm = document.querySelector('.new_vending_form');

    let data = new FormData(newVendingForm);
    data.append('context', 'newVending');

    if (newVendingForm.checkValidity()) {
    fetch(url.toString(), {method: 'POST', body: data})
        .then( response => response.text())
        .then( data => {
            const containerVendingList = document.querySelector('.vending_list_container');
            containerVendingList.innerHTML = data;
            const gridContainer = document.querySelectorAll('.grid_container');
            buildGridTemplateColumns(gridContainer);
        })
        .then( () => {
            const btnSubmitNewVending = document.querySelector('.new_vending_submit');
            btnSubmitNewVending.removeEventListener('click', handleClickSubmitNewVending);

            const vendings = document.querySelectorAll('ul.vending');
            vendings.forEach(vending => {
                vending.addEventListener('click', handleClickVendingList);
            })

            const containerNewVendingForm = document.querySelector('.container_new_vending_form');
            const btnBackAddVendingToVendingList = document.querySelector('.btn_back_add_vending_to_vendingList');

            toggleClass(btnAddVending, 'hidden');
            btnAddVending.addEventListener('click', handleClickBtnAddVending);

            toggleClass(btnBackAddVendingToVendingList, 'hidden');
            toggleClass(containerNewVendingForm, 'hidden');
        })
    } else {
        const invalidFields = Array.from(newVendingForm.elements).filter(element => !element.validity.valid);

        invalidFields.forEach( field => {
            field.classList.add("field_empty");
        });
    }
}

const btnAddVending = document.querySelector('.btn_add_vending');
btnAddVending.addEventListener('click', handleClickBtnAddVending);