
let baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
let url = new URL('ajax.php', baseUrl);

// Fonction qui attache les écouteurs d'événements à un conteneur donné
function userModifyAttachEventListeners(container) {

    listenUpdateButton(container);

    listenSaveButton(container);

    listenDeleteButton(container);

}

// Attache l'écouteur d'événement aux elements .update d'un conteneur donné
// AJAX pour mettre a jours les données en bdd et retirer l'élément du DOM
function listenUpdateButton(container)
{
    // Sélectionner tous les boutons de mise à jour dans le conteneur
    let updateButtons = container.querySelectorAll('.update');
    // Pour chaque bouton de mise à jour
    updateButtons.forEach(button => {

        // Ajouter un écouteur d'événements
        button.addEventListener('click', (event) => {
            event.preventDefault();
            let userElement = event.currentTarget.closest('[data-user-id]');
            updateUserElement(userElement)
        });
    });
}

// Attache l'écouteur d'événement aux elements .save d'un conteneur donné
// AJAX pour sauvegarder les données en bdd et mettre à jour l'élément du DOM
// avec les données récupérées
function listenSaveButton(container)
{
    // Sélectionner tous les boutons de sauvegarde dans le conteneur
    let saveButtons = container.querySelectorAll('.save');
    // Ajouter un écouteur d'événements pour chaque bouton de sauvegarde
    saveButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            let userElement = event.currentTarget.closest('[data-user-id]');


            // Créer un objet FormData pour envoyer une requête AJAX au serveur
            let formData = new FormData(userElement);

            formData.append('context', 'usersRefresh');
            formData.append('user_id', userElement.dataset.userId);

            // Envoyer la requête AJAX et remplacer le conteneur avec la réponse
            fetch(url.toString(), { method: 'POST', body: formData })
                .then(response => response.text())
                .then(data => replaceContainer(userElement, data));
        });
    });
}

// Attache l'écouteur d'événement aux elements .delete d'un conteneur donné
// AJAX pour supprimer les données en bdd et retirer l'élément du DOM
function listenDeleteButton(container)
{
    // Sélectionner tous les boutons de suppression dans le conteneur
    let deleteButtons = container.querySelectorAll('.delete');
    // Ajouter un écouteur d'événements pour chaque bouton de suppression
    deleteButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            let userElement = event.currentTarget.closest('[data-user-id]');

            // Créer un objet FormData pour envoyer une requête AJAX au serveur
            let formData = new FormData();
            formData.append('context', 'usersDelete');
            formData.append('user_id', userElement.dataset.userId);

            // Envoyer la requête AJAX et supprime le conteneur en cas de succes
            fetch(url.toString(), { method: 'POST', body: formData })
                .then(() => deleteContainer(userElement));
        });
    });
}

// fonction qui ajoute ou supprime l'attribut disable sur chaque input d'un formulaire donné
function toggleDisabledForm(formElement) {
    let inputItems = formElement.querySelectorAll('form input[disabled],form select[disabled]');
    for (let i = 0; i < inputItems.length; i++) {
        inputItems[i].disabled = !inputItems[i].disabled;
    }
}

// fonction qui utilise toggle pour la classe hidden sur tous les boutons d'un formulaire donné
function toggleBtn(formElement) {
    let buttons = formElement.querySelectorAll('button');
    buttons.forEach(function (button) {
        button.classList.toggle("hidden")
    });
}

// Fonction qui met à jour un élément avec les données fournies
function updateUserElement(userElement){
    toggleDisabledForm(userElement);
    toggleBtn(userElement);
    userModifyAttachEventListeners(userElement);

    let allUserElements = document.querySelectorAll('[data-user-id]');
    allUserElements.forEach((element) => {
        if (element !== userElement) {
            let userButton = element.querySelectorAll('.update, .delete');
            userButton.forEach(button => {
                button.disabled = true;
            })
        }
    });
}

// Fonction qui remplace un conteneur avec les données fournies
function replaceContainer(container, data){
    container.innerHTML = data;
    userModifyAttachEventListeners(container);
}

// Fonction qui supprime un conteneur
function deleteContainer(container){
    container.parentNode.removeChild(container);
}

// Attache les écouteurs d'événements initiaux au document
let usersContainer = document.querySelector('.UsersContainer');
userModifyAttachEventListeners(usersContainer);