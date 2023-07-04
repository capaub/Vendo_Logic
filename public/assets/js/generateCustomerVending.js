

export function attachEventListenerCustomerVending()
{
    const vendings = document.querySelectorAll('.Vending');
    vendings.forEach(vending => {
        vending.addEventListener('click', generateCustomerVending)
    })
}

function generateCustomerVending(event)
{
    const vending = event.currentTarget;
    const vendingId = vending.dataset.vendingId;
    const baseUrl = window.location.origin + window.location.pathname;
    const url = new URL(baseUrl);
    url.searchParams.set('page','vending');
    url.searchParams.set('vending_id',vendingId);

    window.location.href = url.href;

}

attachEventListenerCustomerVending()