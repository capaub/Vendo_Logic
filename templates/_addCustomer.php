<main class="Container_main Main CustomerContainer customerContainer">
    <h1 class="Main_title">Création d'un client</h1>

    <button class="btnBackToCustomers" data-text="Annuler"></button>

    <div class="container_new_customer_form">

        <form method="POST"
              class="form_container new_customer_form">
            <fieldset class="fieldset">
                <legend>Renseignements cLient</legend>
                <div class="elements">
                    <input type="text"
                           class=""
                           id="company_siret"
                           name="field_company_siret"
                           maxlength="14"
                           data-placeholder="ex: 123456789"
                           required="required">
                    <label for="company_siret">n° de siret</label>
                </div>
                <div class="elements">
                    <input type="text"
                           class=""
                           id="company_name"
                           name="field_company_name"
                           data-placeholder="ex: Mon entreprise"
                           required="required">
                    <label for="company_name">Nom de la société</label>
                </div>
            </fieldset>
            <fieldset class="fieldset">
<!--                <legend>Contact</legend>-->

                <div class="elements">
                    <input type="text"
                           id="country"
                           name="field_country"
                           data-placeholder="ex: France"
                           required="required">
                    <label for="country">Pays</label>
                </div>

                <div class="elements">
                    <input type="text"
                           id="city"
                           name="field_city"
                           data-placeholder="ex: Marseille"
                           required="required">
                    <label for="city">Ville</label>
                </div>

                <div class="elements">
                    <input type="number"
                           id="postal_code"
                           name="field_postal_code"
                           data-max-length="5"
                           data-placeholder="ex: 83640"
                           required="required">
                    <label for="postal_code">Code postal</label>
                </div>

                <div class="elements">
                    <input type="text"
                           class=""
                           id="street_name"
                           name="field_street_name"
                           data-placeholder="ex: Avenue Julien Jourdan"
                           required="required">
                    <label for="street_name">Rue</label>
                </div>
                <div class="elements">
                    <input type="text"
                           class=""
                           id="email"
                           name="field_email"
                           data-placeholder="ex: a.dupont@mail.com"
                           required="required">
                    <label for="email">Email</label>
                </div>
                <div class="elements">
                    <input type="text"
                           class=""
                           id="phone"
                           name="field_phone"
                           maxlength="10"
                           data-placeholder="ex: 04 10 10 10 10"
                           required="required">
                    <label for="phone">Téléphone</label>
                </div>
                <div class="elements">
                    <input type="text"
                           class=""
                           id="firstname"
                           name="field_firstname"
                           data-placeholder="ex: Alfred"
                           required="required">
                    <label for="firstname">Prénom</label>
                </div>
                <div class="elements">
                    <input type="text"
                           class=""
                           id="lastname"
                           name="field_lastname"
                           data-placeholder="ex: Dupont"
                           required="required">
                    <label for="lastname">Nom</label>
                </div>

            </fieldset>

                <input type="submit" class="new_customer_submit">

        </form>

    </div>
</main>

<!--        <section class="Main_customers_customer Customer alert">-->
<!--            <fieldset>-->
<!--                <legend>Les plages d'interventions possible</legend>-->
<!--                <form method="POST">-->
<!--                    <div>-->
<!--                    <button type="button" value="Monday">Lundi</button>-->
<!--                    <button type="button" value="Tuesday">Mardi</button>-->
<!--                    <button type="button" value="Wednesday">Mercredi</button>-->
<!--                    <button type="button" value="Thursday">Jeudi</button>-->
<!--                    <button type="button" value="Friday">Vendredi</button>-->
<!--                    <button type="button" value="Saturday">Samedi</button>-->
<!--                    <button type="button" value="Snuday">Dimanche</button>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <input type="time"-->
<!--                               class=""-->
<!--                               id="start_first"-->
<!--                               name="filed_start_first"-->
<!--                               required>-->
<!--                        <input type="time"-->
<!--                               class=""-->
<!--                               id="end_first"-->
<!--                               name="filed_end_first"-->
<!--                               required>-->
<!--                        <input type="time"-->
<!--                               class=""-->
<!--                               id="start_second"-->
<!--                               name="filed_start_second"-->
<!--                               required>-->
<!--                        <input type="time"-->
<!--                               class=""-->
<!--                               id="end_second"-->
<!--                               name="filed_end_second"-->
<!--                               required>-->
<!--                        <input type="submit">-->
<!--                    </div>-->
<!--                </form>-->
<!--            </fieldset>-->
<!--        </section>-->
<!--    </div>-->

