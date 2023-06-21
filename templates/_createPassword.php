<main class="Main">

    <form data-user-id="<?= $user->getId() ?>"
          method="POST"
          class="form_container">
        <fieldset class="fieldset">
            <legend>Création du mots de passe</legend>
            <input type="hidden" name="data-user-id" value="<?= $user->getId() ?>">

            <div class="elements">
                <input class="input-form" type="password" id="password" name="field_password">
                <label for="password">Mot de passe</label>
            </div>

            <div class="elements">
                <input class="input-form" type="password" id="password_confirm" name="field_password_confirm">
                <label for="password_confirm">Confirmer le mot de passe</label>
            </div>

        </fieldset>

        <input class="savePassword" type="submit" name="form_login" value="Soumettre">
<!--        <a href="?page=--><?php //= PAGE_REGISTER ?><!--">Inscription</a>-->

<!--        <div class="elements submit">-->
<!--            <button class="savePassword">Soumettre</button>-->
<!--        </div>-->
    </form>
</main>

<script type="module" src="../assets/js/createPassword.js"></script>