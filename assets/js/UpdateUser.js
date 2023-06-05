import {buildGridTemplateColumns, toggleClass} from "./global.js";

let baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
let url = new URL('ajax.php', baseUrl);


function listenUpdateButton(container) {
    let updateButtons = container.querySelectorAll('.update');
    updateButtons.forEach(button => {
        button.addEventListener('click', updateUser);
    });
}
function updateUser(event) {
    event.preventDefault();
    let userElement = event.currentTarget.closest('[data-user-id]');
    DisableOtherButton(userElement);
    listenCancelButton(userElement)
}
function DisableOtherButton(userElement) {
    toggleDisabledForm(userElement);

    listenSaveButton(userElement);
    listenDeleteButton(userElement);

    let allUserElements = document.querySelectorAll('[data-user-id]');
    allUserElements.forEach((element) => {
        if (element !== userElement) {
            let userButton = element.querySelectorAll('.update, .delete');
            userButton.forEach(button => {
                button.disabled = true;
            })
        }
    });
    toggleBtns(userElement);
}

function listenDeleteButton(container) {
    let deleteButtons = container.querySelectorAll('.delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', deleteUser);
    });
}
function deleteUser(event) {
    event.preventDefault();
    if (window.confirm('souhaitez-vous vraiment supprimer cet utilisateur ?')) {
        let userElement = event.currentTarget.closest('[data-user-id]');

        let formData = new FormData();
        formData.append('context', 'usersDelete');
        formData.append('user_id', userElement.dataset.userId);

        fetch(url.toString(), {method: 'POST', body: formData})
            .then(() => deleteContainer(userElement));
    }
}

function listenSaveButton(container) {
    let saveButton = container.querySelector('.save');
    saveButton.setAttribute("disabled", "disabled");
    container.addEventListener('change', removeDisabledOnSaveButton);

    saveButton.addEventListener('click', userSaveChange);
}
function userSaveChange(event) {
    event.preventDefault();
    let userElement = event.currentTarget.closest('[data-user-id]');

    let formData = new FormData(userElement);
    formData.append('context', 'usersRefresh');
    formData.append('user_id', userElement.dataset.userId);

    fetch(url.toString(), {method: 'POST', body: formData})
        .then(response => response.text())
        .then(data => replaceContainer(userElement, data))
        .then( () => {
            let container = document.querySelector('.UsersContainer')
            removeDisabled(container)
        } )
}

function listenCancelButton(container) {

    let cancelButton = container.querySelector('.cancel');
    cancelButton.addEventListener('click', cancelModify);
}
function cancelModify(event) {
    event.preventDefault();
    let userForm = event.currentTarget.closest('[data-user-id]');
    toggleBtns(userForm);
    toggleDisabledForm(userForm);

    let container = document.querySelector('.UsersContainer');
    removeDisabled(container);
}


function removeDisabledOnSaveButton(event) {
    let saveButton = event.currentTarget.querySelector('.save');
    saveButton.removeAttribute("disabled");
}

function toggleDisabledForm(formElement) {
    let inputItems = formElement.querySelectorAll('form input,form select');
    for (let i = 0; i < inputItems.length; i++) {
        inputItems[i].disabled = !inputItems[i].disabled;
    }
}

function toggleBtns(formElement) {

    let buttons = formElement.querySelectorAll('button');
    buttons.forEach(button => {
        toggleClass(button, "hidden")
    });
}

function removeDisabled(container)
{
    let userButton = container.querySelectorAll('.update, .delete');
    userButton.forEach(button => {
        button.disabled = false;
    })
}
function replaceContainer(container, data) {
    container.innerHTML = data;
    listenUpdateButton(container);
    listenDeleteButton(container);
}

function deleteContainer(container) {
    container.parentNode.removeChild(container);
}

const gridContainerForm = document.querySelectorAll('.grid_container_form');
buildGridTemplateColumns(gridContainerForm);

let usersContainer = document.querySelector('.UsersContainer');
listenUpdateButton(usersContainer);
listenDeleteButton(usersContainer);


// TODO Bibliothèque sweetAlert2 pour gérer le confirm
// npm install sweetalert2
// <script type="module" src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
// import Swal from "../../node_modules/sweetalert2/src/sweetalert2.js";
// Swal.fire({
//            title: 'Warning',
//            text: 'Vous êtes sur le point de suprimer un utilisateur !',
//            icon: 'warning',
//            confirmButtonText: 'Je suis sur',
//            showCancelButton: 'true',
//            cancelButtonText: 'Annuler'
//        }).then( () => console.log('coucou'))