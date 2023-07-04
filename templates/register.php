<main class="Container_main Main">
    <h1 class="Main_title">Formulaire d'inscription</h1>
    <div class="container_register_form">
        <form method="POST" class="form_container">

            <div class="fieldset">
                <div class="elements">
                    <input required type="text" id="company_name" name="field_company_name">
                    <label for="company_name">Nom de l'entreprise</label>
                </div>

                <div class="elements">
                    <input required type="text" id="siret" name="field_siret" maxlength="14" pattern="{0,9}">
                    <label for="siret">N° de siret</label>
                </div>

            </div>
            <div class="fieldset">

                <div class="elements">
                    <input required type="text" id="firstname" name="field_firstname">
                    <label for="firstname">Prénom</label>
                </div>

                <div class="elements">
                    <input required type="text" id="lastname" name="field_lastname">
                    <label for="lastname">Nom</label>
                </div>

                <div class="elements">
                    <input required type="text" id="country" name="field_country">
                    <label for="country">Pays</label>
                </div>

                <div class="elements">
                    <input required type="text" id="city" name="field_city">
                    <label for="city">Ville</label>
                </div>

                <div class="elements">
                    <input required type="number" id="postal_code" name="field_postal_code" data-max-length="5">
                    <label for="postal_code">Code postal</label>
                </div>

                <div class="elements">
                    <input required type="text" id="street_name" name="field_street_name">
                    <label for="street_name">Rue</label>
                </div>

                <div class="fieldset">

                    <div class="elements">
                        <input required type="email" id="email" name="field_email">
                        <label for="email">Email</label>
                    </div>

                    <div class="elements">
                        <input required type="password" id="password" name="field_password">
                        <label for="password">Mot de passe</label>
                    </div>

                    <div class="elements">
                        <input required type="password" id="password_confirm" name="field_password_confirm">
                        <label for="password_confirm">Confirmer mot de passe</label>
                    </div>

                </div>

            </div>

            <input type="submit" name="form_register" value="Inscription">
            <a href="?page=<?= PAGE_LOGIN ?>">Connexion</a>

        </form>
    </div>
</main>
