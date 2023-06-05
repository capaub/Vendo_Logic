// import {toggleClass} from "./global.js";

import {buildGridTemplateColumns} from "./global.js";

const baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
const url = new URL('ajax.php', baseUrl);

const usersContainer = document.querySelector('.UsersContainer');

const token = 'hidden';
const containerFormNewUser = document.querySelector('.container_new_user_form');

const sectionUserList = document.querySelector('.list_container.user');
const formNewUser = containerFormNewUser.querySelector('.new_user_form');

const addUserButton = document.querySelector('.btnAddUser')



function toggleClass(elements, token)
{
    elements.classList.toggle(token);
}

function listenCloseButton() {
    let close = document.querySelector('.closeNewUserForm');

    close.addEventListener('click', (event) => {
        event.preventDefault();

        toggleClass(containerFormNewUser, token);
    });
}

function formNewUserAttachEventListeners(formNewUser) {

    let submitButton = formNewUser.querySelector('.newUserSubmit');
    submitButton.addEventListener('click', (event) => {
        event.preventDefault();
        newUser(formNewUser);
    })
}

function newUser(formNewUser) {

    let formData = new FormData(formNewUser)
    formData.append('context', 'newUser');

    fetch(url.toString(), {method: 'POST', body: formData})
        .then( response => response.text() )
        .then( data => refreshUserList(data) )
        .then( () => toggleClass(sectionFormNewUser,token) )
        .then( () => {
            console.log('coucou')
            const gridContainer = document.querySelectorAll('.grid_container');
            console.log(gridContainer)
            buildGridTemplateColumns(gridContainer)
        })
        // .then( () => userModifyAttachEventListeners(usersContainer) );
}

function refreshUserList(data){
    sectionUserList.innerHTML = data;
}

addUserButton.addEventListener('click', ()=> {

    toggleClass(containerFormNewUser,token);
})

listenCloseButton();
formNewUserAttachEventListeners(formNewUser);