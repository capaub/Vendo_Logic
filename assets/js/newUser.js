// import {toggleClass} from "./global.js";

let baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
let url = new URL('ajax.php', baseUrl);

let usersContainer = document.querySelector('.UsersContainer');

let token = 'hidden';
let sectionFormNewUser = document.querySelector('.new_user_section');

let sectionUserList = document.querySelector('.list_container.user');
let formNewUser = sectionFormNewUser.querySelector('.new_user_form');

let addUserButton = document.querySelector('.btnAddUser')



function toggleClass(elements, token)
{
    elements.classList.toggle(token);
}


addUserButton.addEventListener('click', ()=> {

    toggleClass(sectionFormNewUser,token);
})

function listenCloseButton() {
    let close = document.querySelector('.closeNewUserForm');

    close.addEventListener('click', (event) => {
        event.preventDefault();

        toggleClass(sectionFormNewUser, token);
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

    let firstnameSibling = formNewUser.querySelector('input[name=field_firstname]');
    let firstname = firstnameSibling.value;

    let lastnameSibling = formNewUser.querySelector('input[name=field_lastname]');
    let lastname = lastnameSibling.value;

    let emailSibling = formNewUser.querySelector('input[name=field_email]');
    let email = emailSibling.value;

    let roleSibling = formNewUser.querySelector('select[name=field_role]');
    let role = roleSibling.value;

    let formData = new FormData()
    formData.append('context', 'newUser');
    formData.append('field_firstname', firstname);
    formData.append('field_lastname', lastname);
    formData.append('field_email', email);
    formData.append('field_role', role);

    fetch(url.toString(), {method: 'POST', body: formData})
        .then( response => response.text() )
        .then( data => refreshUserList(data) )
        .then( () => toggleClass(sectionFormNewUser,token) )
        .then( () => userModifyAttachEventListeners(usersContainer) );
}

function refreshUserList(data){
    sectionUserList.innerHTML = data;
}

listenCloseButton();
formNewUserAttachEventListeners(formNewUser);