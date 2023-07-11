import {buildGridTemplateColumns} from "./global.js";

const baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
const url = new URL('ajax.php', baseUrl);

const containerFormNewUser = document.querySelector('.container_new_user_form');

const sectionUserList = document.querySelector('.list_container.user');
const formNewUser = containerFormNewUser.querySelector('.new_user_form');

const addUserButton = document.querySelector('.btnAddUser')

function listenCloseButton() {
    const close = document.querySelector('.closeNewUserForm');

    close.addEventListener('click', (event) => {
        event.preventDefault();
        containerFormNewUser.classList.toggle('hidden');
    });
}

function formNewUserAttachEventListeners(formNewUser) {

    const submitButton = formNewUser.querySelector('.newUserSubmit');
    submitButton.addEventListener('click', (event) => {
        event.preventDefault();
        newUser(formNewUser);
    })
}


function newUser(formNewUser) {

    let formData = new FormData(formNewUser)
    formData.append('context', 'newUser');

    if (formNewUser.checkValidity()) {
        const btn = document.querySelector('.newUserSubmit');
        const loader = document.querySelector('.loader');
        btn.classList.toggle('hidden');
        loader.classList.toggle('hidden');

        fetch(url.toString(), {method: 'POST', body: formData})
            .then(response => response.text())
            .then(data => {
                btn.classList.toggle('hidden');
                loader.classList.toggle('hidden');
                refreshUserList(data)
            })
            .then(() => {
                formNewUser.reset();
                containerFormNewUser.classList.toggle('hidden')
            })
            .then(() => {
                const gridContainer = document.querySelectorAll('.grid_container');
                buildGridTemplateColumns(gridContainer)
            })
    } else {
        const invalidFields = Array.from(formNewUser.elements).filter(element => !element.validity.valid);

        invalidFields.forEach(field => {
            field.classList.add("field_empty");
        });
    }
}


function refreshUserList(data) {
    sectionUserList.innerHTML = data;
}

addUserButton.addEventListener('click', () => {
    containerFormNewUser.classList.toggle('hidden');
})

listenCloseButton();
formNewUserAttachEventListeners(formNewUser);

