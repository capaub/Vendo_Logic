export function sortCustomers() {
    const container = document.querySelector('.Main_customers');

    if (container !== null) {
        const elements = container.children;

        const sortedElements = Array.from(elements).sort(function (a) {
            const aHasClass = a.classList.contains('alert');

            if (aHasClass) {
                return -1;
            } else {
                return 1;
            }
        });

        sortedElements.forEach(function (element) {
            container.appendChild(element);
        });
    }
}

sortCustomers();