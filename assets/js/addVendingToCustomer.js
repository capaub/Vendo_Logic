

function attachEventListeners(container) {

    let baseUrl = window.location.origin + window.location.pathname.replace('index.php', 'ajax.php');
    let url = new URL('ajax.php', baseUrl);

    let customers = container.querySelectorAll('section.ajaxCustomer');

    customers.forEach(customer => {
        customer.addEventListener('click', (event) => {
            let id = event.currentTarget.dataset.customerId;
            let companyName = event.currentTarget.dataset.companyName;


            let addVendingContainer = document.querySelector('.addVendingContainer');

            let data = new FormData();
            data.append('context', 'showContainerAddVending');
            data.append('customer_id', id);
            data.append('customer_company_name', companyName);

            console.log(data)
            fetch(url.toString(), {method: 'POST', body: data})
                .then(response => response.text())
                .then(data => replaceContainer(addVendingContainer,data))
        });
    });

    let addVendingSubmit = container.querySelector('.addVending');

    if (addVendingSubmit !== null) {

        addVendingSubmit.addEventListener('click', (event) => {
            event.preventDefault();

            let formElement = event.currentTarget.closest('[data-customer-id]');

            let id = formElement.dataset.customerId;

            let formData = new FormData(formElement);
            formData.append('context', 'addVendingToCustomer');
            formData.append('customer_id', id);

            fetch(url.toString(), {method: 'POST', body: formData})
                .then(response => response.text())
                .then(data => console.log(data))
        });
    }

}

// Fonction qui remplace un conteneur avec les données fournies
function replaceContainer(container, data){
    container.innerHTML = data;
    showCustomerContainer(container);
    attachEventListeners(container);
}

function showCustomerContainer(container)
{
    container.classList.remove('hidden');
}

let customerContainer = document.querySelector('.CustomerContainer');

// Attache les écouteurs d'événements initiaux au document
attachEventListeners(customerContainer);