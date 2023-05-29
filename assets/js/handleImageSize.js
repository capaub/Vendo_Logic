

export function handleImageSize(parentContainer, backgroundImageURL, selector) {

    const imageContainer = parentContainer.querySelector(selector);


    const image = new Image();
    image.src = backgroundImageURL;

    image.addEventListener('load', function() {

        if (image.naturalWidth < image.naturalHeight) {
            styleImagePortrait(imageContainer, backgroundImageURL);
        } else if (image.naturalWidth > image.naturalHeight) {
            styleImageLandscape(imageContainer, backgroundImageURL);
        }

    });
}

function styleImageLandscape(element,imageUrl) {

    element.style.height= '40px';
    element.style.width= '80px';
    element.style.backgroundImage= `url(${imageUrl})`;
    element.style.backgroundSize= '100%'; /* Ajustez la propriété de dimension du fond selon vos besoins */
    element.style.backgroundRepeat= 'no-repeat';
    element.style.backgroundPosition= 'center';
    element.style.transform= 'translate(-20px, 20px) rotate(270deg)';
}

function styleImagePortrait(element,imageUrl) {

    element.style.height= '80px';
    element.style.width= '40px';
    element.style.backgroundImage = `url(${imageUrl})`;
    element.style.backgroundSize = 'auto 100%';
    element.style.backgroundRepeat = 'no-repeat';
    element.style.backgroundPosition = 'center';

}

