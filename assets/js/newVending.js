import { toggleClass } from "./global.js";
import { handleClickVendingList } from "./showVending.js";

let baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
let url = new URL('ajax.php', baseUrl);

function handleClickBtnBackToVendingList() {

    let newVendingForm = document.querySelector('.new_vending_form');
    let btnAddVending = document.querySelector('.btnAddVending');
    let btnBackAddVendingToVendingList = document.querySelector('.btnBackAddVendingToVendingList');

    toggleClass(btnAddVending, 'hidden');
    toggleClass(btnBackAddVendingToVendingList, 'hidden');
    toggleClass(newVendingForm, 'hidden');


    btnAddVending.addEventListener('click', handleClickBtnAddVending);

    let vendings = document.querySelectorAll('ul.vending');

    vendings.forEach(vending => {
        vending.addEventListener('click', handleClickVendingList);
    })

    btnBackAddVendingToVendingList.removeEventListener('click', handleClickBtnBackToVendingList);

}

function handleClickBtnAddVending() {

    let newVendingForm = document.querySelector('.new_vending_form');
    let btnAddVending = document.querySelector('.btnAddVending');
    let btnBackAddVendingToVendingList = document.querySelector('.btnBackAddVendingToVendingList');


    toggleClass(btnAddVending, 'hidden');
    toggleClass(btnBackAddVendingToVendingList, 'hidden');
    toggleClass(newVendingForm, 'hidden');


    btnAddVending.removeEventListener('click', handleClickBtnAddVending);

    btnBackAddVendingToVendingList.addEventListener('click', handleClickBtnBackToVendingList);

    let vendings = document.querySelectorAll('ul.vending');

    vendings.forEach(vending => {
        vending.removeEventListener('click', handleClickVendingList);
    })
}
let btnSubmitNewVending = document.querySelector('.new_vending_submit');
btnSubmitNewVending.addEventListener('click', (event)=> {
    event.preventDefault();
    let newVendingForm = document.querySelector('.add_vending_form');
    let data = new FormData(newVendingForm);
    data.append('context', 'newVending');

    fetch(url.toString(), {method: 'POST', body: data})
        .then( response => response.text())
        .then( data => {
            let containerVendingList = document.querySelector('.container_vending_list');
            containerVendingList.innerHTML = data
        })
        .then( () => {
            let vendings = document.querySelectorAll('ul.vending');

            vendings.forEach(vending => {
                vending.addEventListener('click', handleClickVendingList);
            })
            let btnAddVending = document.querySelector('.btnAddVending');
            btnAddVending.addEventListener('click', handleClickBtnAddVending);
            let newVendingForm = document.querySelector('.new_vending_form');
            let btnBackAddVendingToVendingList = document.querySelector('.btnBackAddVendingToVendingList');


            toggleClass(btnAddVending, 'hidden');
            toggleClass(btnBackAddVendingToVendingList, 'hidden');
            toggleClass(newVendingForm, 'hidden');
        })
})


let btnAddVending = document.querySelector('.btnAddVending');
btnAddVending.addEventListener('click', handleClickBtnAddVending);