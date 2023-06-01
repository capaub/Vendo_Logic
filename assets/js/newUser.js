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

function listenCloseButton() {
    let close = document.querySelector('.closeNewUserForm');

    close.addEventListener('click', (event) => {
        event.preventDefault();

        toggleClass(sectionFormNewUser, token);
    });
}

function formNewUserAttachEventListeners(formNewUser) {

    console.log(formNewUser)

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
        // .then( () => userModifyAttachEventListeners(usersContainer) );
}

function refreshUserList(data){
    sectionUserList.innerHTML = data;
}

addUserButton.addEventListener('click', ()=> {

    toggleClass(sectionFormNewUser,token);
})

listenCloseButton();
formNewUserAttachEventListeners(formNewUser);