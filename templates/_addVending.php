

    <form method="POST"
          action="?page=<?= PAGE_SAVE_VENDING ?>"
          class="form_container add_vending_form">

        <div class="elements submit">
            <button class="close closeNewUserForm">X</button>
        </div>

        <fieldset class="fieldset">
            <legend>Informations machine</legend>

            <div class="elements">
                <label for="brand">Marque</label>
                <input type="text" name="field_brand" id="brand">
            </div>

            <div class="elements">
                <label for="model">Model</label>
                <input type="text" name="field_model" id="model">
            </div>

            <div class="elements">
                <label for="max_tray">Plateaux max</label>
                <input type="text" name="field_max_tray" id="max_tray">
            </div>

            <div class="elements">
                <label for="max_spiral">Spirale max</label>
                <input type="text" name="field_max_spiral" id="max_spiral">
            </div>

        </fieldset>

        <div class="elements submit">
            <button class="new_vending_submit">Enregistrer</button>
        </div>
    </form>

