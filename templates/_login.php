<main class="Container_main Main">

    <div class="container_login_form">
        <form method="POST" class="form_container Login">

            <fieldset class="fieldset">
                <legend>Connexion</legend>

                <div class="elements">
                    <input type="email" id="email" name="field_email">
                    <label for="email">Adresse email</label>
                </div>

                <div class="elements">
                    <input type="password" id="password" name="field_password">
                    <label for="password">Mot de passe</label>
                </div>

            </fieldset>

            <input type="submit" name="form_login" value="Connexion">
            <a href="?page=<?= PAGE_REGISTER ?>">Inscription</a>

        </form>
    </div>
</main>