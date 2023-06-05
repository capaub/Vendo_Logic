import {buildGridTemplateColumns, moveLabel, toggleClass} from "./global.js";
import { handleClickVendingList } from "./showVending.js";

const baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
const url = new URL('ajax.php', baseUrl);

function handleClickBtnBackToVendingList() {

    const newVendingForm = document.querySelector('.new_vending_form');
    const btnAddVending = document.querySelector('.btnAddVending');
    const btnBackAddVendingToVendingList = document.querySelector('.btnBackAddVendingToVendingList');

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
const handleClickCloseButton = (event) => {
    event.preventDefault();

    const containerNewVendingForm = document.querySelector('.container_new_vending_form');
    const btnAddVending = document.querySelector('.btnAddVending');
    const btnBackAddVendingToVendingList = document.querySelector('.btnBackAddVendingToVendingList');

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
    const btnAddVending = document.querySelector('.btnAddVending');
    const btnBackAddVendingToVendingList = document.querySelector('.btnBackAddVendingToVendingList');

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

let handleClickSubmitNewVending = (event)=> {
    event.preventDefault();
    const newVendingForm = document.querySelector('.new_vending_form');
    let data = new FormData(newVendingForm);
    data.append('context', 'newVending');

    if (newVendingForm.checkValidity()) {
    fetch(url.toString(), {method: 'POST', body: data})
        .then( response => response.text())
        .then( data => {
            const containerVendingList = document.querySelector('.vendingListContainer');
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
            const btnBackAddVendingToVendingList = document.querySelector('.btnBackAddVendingToVendingList');

            toggleClass(btnAddVending, 'hidden');
            btnAddVending.addEventListener('click', handleClickBtnAddVending);

            toggleClass(btnBackAddVendingToVendingList, 'hidden');
            toggleClass(containerNewVendingForm, 'hidden');
        })
    } else {
        const elementsInvalides = Array.from(newVendingForm.elements).filter(element => !element.validity.valid);


        console.log("on est là pas bon ")
        // Parcours des éléments non valides
        elementsInvalides.forEach( element => {
            element.classList.add("field_empty");
        });
    }
}

let btnAddVending = document.querySelector('.btnAddVending');
btnAddVending.addEventListener('click', handleClickBtnAddVending);