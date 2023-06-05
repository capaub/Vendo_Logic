<main class="Container_main Main">
<!--    <h1 class="Main_title">Formulaire d'inscription</h1>-->
    <div class="container_register_form">
    <form method="POST" class="form_container">
        <div class="fieldset">
            <legend>FORMULAIRE D'INSCRIPTION</legend>
            <div class="elements">
                <label for="company_name">Nom de l'entreprise</label>
                <input required type="text" id="company_name" name="field_company_name">
            </div>

            <div class="elements">
                <label for="siret">N° de siret</label>
                <input required type="text" id="siret" name="field_siret" maxlength="14">
            </div>

        </div>
        <div class="fieldset">

            <div class="elements">
                <label for="firstname">Prénom</label>
                <input required type="text" id="firstname" name="field_firstname">
            </div>

            <div class="elements">
                <label for="lastname">Nom</label>
                <input required type="text" id="lastname" name="field_lastname">
            </div>

            <div class="elements">
                <label for="country">Pays</label>
                <input required type="text" id="country" name="field_country">
            </div>

            <div class="elements">
                <label for="city">Ville</label>
                <input required type="text" id="city" name="field_city">
            </div>

            <div class="elements">
                <label for="postal_code">Code postal</label>
                <input required type="number" id="postal_code" name="field_postal_code" maxlength="5">
            </div>

            <div class="elements">
                <label for="street_name">Rue</label>
                <input required type="text" id="street_name" name="field_street_name">
            </div>

            <div class="fieldset">

                <div class="elements">
                    <label for="email">Email</label>
                    <input required type="email" id="email" name="field_email">
                </div>
    
                <div class="elements">
                    <label for="password">Mot de passe</label>
                    <input required type="password" id="password" name="field_password">
                </div>
    
                <div class="elements">
                    <label for="password_confirm">Confirmer mot de passe</label>
                    <input required type="password" id="password_confirm" name="field_password_confirm">
                </div>

            </div>

        </div>


        <input type="submit" name="form_register" value="Inscription">
        <a href="?page=<?= PAGE_LOGIN ?>">Connexion</a>


    </form>
    </div>
</main>
