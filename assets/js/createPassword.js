import {moveLabel} from "./global.js";

const savePasswordBtn = document.querySelector('.savePassword');

const mainContainer = savePasswordBtn.parentNode.parentNode.parentNode;

savePasswordBtn.addEventListener('click', (event) => {
    event.preventDefault();

    const formElement = savePasswordBtn.closest('[data-user-id]');


    const formData = new FormData(formElement);

    formData.append('context', 'usersUpdate');
    formData.append('id', formElement.getAttribute('data-user-id'));

    fetch('ajax.php', { method: 'POST', body: formData })
        .then( response => response.text() )
        .then( data => {
            reloadLogin(data)
            moveLabel()
        })

})

function reloadLogin(data){
    mainContainer.innerHTML = data;
}