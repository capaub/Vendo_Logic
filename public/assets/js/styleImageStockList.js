export function StyleImageStockList() {

    const stockContainer = document.querySelectorAll('ul.list_stock');
    stockContainer.forEach(batchList => {

        const batchInfo = batchList.querySelectorAll('li.batch_info');
        const numberOfInfo = batchInfo.length;

        batchList.style.gridTemplateColumns = `repeat(${numberOfInfo}, 1fr)`;
        const imgDir = "../public/assets/img/products/";

        batchInfo.forEach(info => {
            let imgContainer = info.querySelector('.batchPicture')

            if (imgContainer !== null) {
                const id = info.dataset.productBarcode;
                const prefix = 'VENLO_';
                const imageUrl = imgDir + prefix + id + '.jpg';
                const selector = '.batchPicture';

                handleImageSize(info, imageUrl, selector);
            }
        })
    })
}

export function handleImageSize(parentContainer, backgroundImageURL, selector) {

    const imageContainer = parentContainer.querySelector(selector);

    const image = new Image();
    image.src = backgroundImageURL;

    image.addEventListener('load', function() {

        if (image.naturalWidth < image.naturalHeight) {
            styleImagePortrait(imageContainer, backgroundImageURL);
        } else if (image.naturalWidth > image.naturalHeight) {
            styleImageLandscape(imageContainer, backgroundImageURL);
            parentContainer.style.padding= '20px 0';
            parentContainer.style.width= '40px';
            parentContainer.style.height= '80px';

        }

    });
}

function styleImageLandscape(element,imageUrl) {

    element.style.height= '40px';
    element.style.width= '80px';
    element.style.backgroundImage= `url(${imageUrl})`;
    element.style.backgroundSize= '100%';
    element.style.backgroundRepeat= 'no-repeat';
    element.style.backgroundPosition= 'center';
    element.style.transform= 'translateX(-20px) rotate(270deg)';
}

function styleImagePortrait(element,imageUrl) {

    element.style.height= '80px';
    element.style.width= '40px';
    element.style.backgroundImage = `url(${imageUrl})`;
    element.style.backgroundSize = 'auto 100%';
    element.style.backgroundRepeat = 'no-repeat';
    element.style.backgroundPosition = 'center';
}

StyleImageStockList()