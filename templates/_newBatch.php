<form method="post" class="search_form form_container">

    <button class="close closeNewBatchForm">X</button>

    <fieldset class="fieldset">
        <legend>Ajouter un lot</legend>

        <div class="elements">
            <input type="number"
                   name="field_barcode"
                   id="barcode"
                   required="required"
                   data-max-length="13">
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