let savePasswordBtn = document.querySelector('.savePassword');

let mainContainer = savePasswordBtn.parentNode.parentNode.parentNode;

savePasswordBtn.addEventListener('click', (event) => {
    event.preventDefault();

    let formElement = savePasswordBtn.closest('[data-user-id]');


    // Créer un objet FormData pour envoyer une requête AJAX au serveur
    const formData = new FormData(formElement);

    formData.append('context', 'usersUpdate');
    formData.append('id', formElement.getAttribute('data-user-id'));

    // Envoyer la requête AJAX et mettre à jour l'élément d'utilisateur avec la réponse
    fetch('ajax.php', { method: 'POST', body: formData })
        .then(response => response.text())
        .then(data=>reloadLogin(data))

})

function reloadLogin(data){
    mainContainer.innerHTML = data;
}