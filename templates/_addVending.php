

    <form method="POST"
          action="?page=<?= PAGE_SAVE_VENDING ?>"
          class="form_container new_vending_form">

            <button class="close close_new_vending_form">X</button>

        <fieldset class="fieldset">
            <legend>Informations machine</legend>

            <div class="elements">
                <input type="text" name="field_brand" id="brand" required="required">
                <label for="brand">Marque</label>
            </div>

            <div class="elements">
                <input type="text" name="field_model" id="model" required="required">
                <label for="model">Model</label>
            </div>

            <div class="elements">
                <input type="text" name="field_max_tray" id="max_tray" required="required">
                <label for="max_tray">Plateaux max</label>
            </div>

            <div class="elements">
                <input type="text" name="field_max_spiral" id="max_spiral" required="required">
                <label for="max_spiral">Spirale max</label>
            </div>

        </fieldset>


            <input type="submit" class="new_vending_submit">

    </form>

