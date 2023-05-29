
    <form method="post" class="search_form form_container">

        <div class="elements submit">
            <button class="close closeNewBatchForm">X</button>
        </div>

        <fieldset class="fieldset">
            <legend>Ajouter un lot</legend>

            <div class="elements">
                <label for="barcode">Code barre</label>
                <input type="number"
                       value="5000159461122"
                       minlength="8"
                       maxlength="13"
                       name="field_barcode"
                       id="barcode">
            </div>


            <div class="elements">
                <label for="quantity">Quantité</label>
                <input type="text"
                       value="50"
                       name="field_quantity"
                       id="quantity">
            </div>


            <div class="elements">
                <label for="dlc">DLC</label>
                <input type="date"
                       name="field_dlc"
                       id="dlc">
            </div>


        </fieldset>

        <div class="elements submit">
            <input type="submit">
        </div>

    </form>

<!--    --><?php //if (isset($product)) :?>
<!--<div>-->
<!--        <p>Catégorie : --><?php //= $product['categories'] ?? ''; ?><!--</p>-->
<!--        <p>Nutri-Score : --><?php //= strtoupper($product['nutriscore_grade']) ?? ''; ?><!--</p>-->
<!--        <p>Marque : --><?php //= $product['brands'] ?? ''; ?><!--</p>-->
<!--        <p>Code-barre : --><?php //= $product['_id'] ?? ''; ?><!--</p>-->
<!--        <p>Quantité : --><?php //= $product['product_quantity'] ?? ''; ?><!--</p>-->
<!--        <p>Mots-clés : --><?php //= implode(', ', $product['_keywords']) ?? ''; ?><!--</p>-->
<!--        <img src="--><?php //= $product['image_url'] ?? ''; ?><!--" alt="">-->
<!--</div>-->
<!--    --><?php //endif; ?>