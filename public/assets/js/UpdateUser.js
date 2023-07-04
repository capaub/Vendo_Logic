import {buildGridTemplateColumns} from "./global.js";
import {SnapShotForm} from "./SnapShotForm.js";

const baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
const url = new URL('ajax.php', baseUrl);

let initialFormValues = {};

function createInitialShot(formUser) {
    const userId = formUser.dataset.userId;
    const snapshotForm = new SnapShotForm(formUser);

    snapshotForm.shot();

    initialFormValues[userId] = snapshotForm;
}

function listenUpdateButton(container) {
    const updateButtons = container.querySelectorAll('.update');
    updateButtons.forEach(button => {
        button.addEventListener('click', updateUser);
    });
}

function updateUser(event) {
    event.preventDefault();
    const userElement = event.currentTarget.closest('[data-user-id]');

    DisableOtherButton(userElement);
    listenCancelButton(userElement);
}

function DisableOtherButton(userElement) {
    toggleDisabledForm(userElement);

    listenSaveButton(userElement);
    listenDeleteButton(userElement);

    const allUserElements = document.querySelectorAll('[data-user-id]');
    allUserElements.forEach((element) => {
        if (element !== userElement) {
            const userButton = element.querySelectorAll('.update, .delete');
            userButton.forEach(button => {
                button.disabled = true;
            })
        }
    });
    toggleBtns(userElement);
}

function listenDeleteButton(container) {
    const deleteButtons = container.querySelectorAll('.delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', deleteUser);
    });
}

function deleteUser(event) {
    event.preventDefault();
    if (window.confirm('souhaitez-vous vraiment supprimer cet utilisateur ?')) {
        const userElement = event.currentTarget.closest('[data-user-id]');

        const formData = new FormData();
        formData.append('context', 'usersDelete');
        formData.append('user_id', userElement.dataset.userId);

        fetch(url.toString(), {method: 'POST', body: formData})
            .then(() => deleteContainer(userElement));
    }
}

function listenSaveButton(container) {
    const saveButton = container.querySelector('.save');
    saveButton.setAttribute("disabled", "disabled");
    container.addEventListener('change', removeDisabledOnSaveButton);

    saveButton.addEventListener('click', userSaveChange);
}

function userSaveChange(event) {
    event.preventDefault();
    const userElement = event.currentTarget.closest('[data-user-id]');

    let formData = new FormData(userElement);
    formData.append('context', 'usersRefresh');
    formData.append('user_id', userElement.dataset.userId);

    if (userElement.checkValidity()) {
        fetch(url.toString(), {method: 'POST', body: formData})
            .then(response => response.text())
            .then(data => replaceContainer(userElement, data))
            .then(() => {
                const usersForm = usersContainer.querySelectorAll('.user form');
                usersForm.forEach(userForm => {
                    createInitialShot(userForm)
                })
                const container = document.querySelector('.UsersContainer')
                removeDisabled(container)
            })
    } else {
        const invalidFields = Array.from(userElement.elements).filter(element => !element.validity.valid);

        invalidFields.forEach(field => {
            field.classList.add("field_empty");
        });
    }
}

function listenCancelButton(container) {
    const cancelButton = container.querySelector('.cancel');
    cancelButton.addEventListener('click', cancelModify);
}

function cancelModify(event) {

    event.preventDefault();
    const userForm = event.currentTarget.closest('[data-user-id]');
    const userId = userForm.dataset.userId;

    initialFormValues[userId].restoreShot();

    toggleBtns(userForm);
    toggleDisabledForm(userForm);

    const container = document.querySelector('.UsersContainer');
    removeDisabled(container);
}

function removeDisabledOnSaveButton(event) {
    const saveButton = event.currentTarget.querySelector('.save');
    saveButton.removeAttribute("disabled");
}

function toggleDisabledForm(formElement) {
    const inputItems = formElement.querySelectorAll('form input,form select');
    for (let i = 0; i < inputItems.length; i++) {
        inputItems[i].disabled = !inputItems[i].disabled;
    }
}

function toggleBtns(formElement) {

    const buttons = formElement.querySelectorAll('button');
    buttons.forEach(button => {
        button.classList.toggle("hidden")
    });
}

function removeDisabled(container) {
    const userButton = container.querySelectorAll('.update, .delete');
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

const usersContainer = document.querySelector('.UsersContainer');
listenUpdateButton(usersContainer);
listenDeleteButton(usersContainer);

const usersForm = usersContainer.querySelectorAll('.user form');
usersForm.forEach(userForm => {
    createInitialShot(userForm)
})

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