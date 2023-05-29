<main class="Main">

    <form data-user-id="<?= $user->getId() ?>"
          method="POST"
          class="form_container">
        <fieldset class="fieldset">
            <legend>Création du mots de passe</legend>
            <input type="hidden" name="data-user-id" value="<?= $user->getId() ?>">
            <div class="elements">
                <label for="password">Mot de passe</label>
                <input class="input-form" type="password" id="password" name="field_password">
            </div>
            <div class="elements">
                <label for="password_confirm">Confirmer le mot de passe</label>
                <input class="input-form" type="password" id="password_confirm" name="field_password_confirm">
        </fieldset>
        <div class="elements submit">
            <button class="savePassword">soumettre</button>
        </div>
    </form>
</main>

<script type="module" src="../assets/js/createPassword.js"></script>