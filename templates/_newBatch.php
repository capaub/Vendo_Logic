
    <form method="post" class="search_form form_container">

            <button class="close closeNewBatchForm">X</button>

        <fieldset class="fieldset">
            <legend>Ajouter un lot</legend>

            <div class="elements">
                <input type="number"
                       minlength="8"
                       maxlength="13"
                       name="field_barcode"
                       id="barcode"
                       required="required">
                <label for="barcode">Code barre</label>
            </div>

            <div class="elements">
                <input type="text"
                       name="field_quantity"
                       id="quantity"
                       required="required">
                <label for="quantity">Quantité</label>
            </div>

            <div class="elements">
                <input type="date"
                       name="field_dlc"
                       id="dlc"
                       required="required">
                <label for="dlc">DLC</label>
            </div>

        </fieldset>

            <input type="submit" class="new_batch_submit">

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