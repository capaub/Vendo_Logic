<main class="Container_main Main CustomerContainer customerContainer">
    <h1 class="Main_title">Création d'un client</h1>

    <section class="new_customer_section">

    <div class="element submit">
        <button class="btnBackToCustomers">Retour</button>
    </div>


        <form method="POST"

              class="form_container new_customer_form">
            <fieldset class="fieldset">
                <legend>Infos Pro.</legend>
                <div class="elements">
                    <label for="company_siret">n° de siret</label>
                    <input type="text"
                           class=""
                           id="company_siret"
                           name="field_company_siret"
                           maxlength="14"
                           placeholder="ex: 123456789"
                           required>
                </div>
                <div class="elements">
                    <label for="company_name">Nom de la société</label>
                    <input type="text"
                           class=""
                           id="company_name"
                           name="field_company_name"
                           placeholder="ex: Mon entreprise"
                           required>
                </div>
            </fieldset>
            <fieldset class="fieldset">
                <legend>Contact</legend>

                <div class="elements">
                    <label for="country">Pays</label>
                    <input required
                           type="text"
                           id="country"
                           name="field_country">
                </div>

                <div class="elements">
                    <label for="city">Ville</label>
                    <input required
                           type="text"
                           id="city"
                           name="field_city">
                </div>

                <div class="elements">
                    <label for="postal_code">Code postal</label>
                    <input required
                           type="number"
                           id="postal_code"
                           maxlength="5"
                           name="field_postal_code">
                </div>

                <div class="elements">
                    <label for="street_name">Rue</label>
                    <input required
                           type="text"
                           id="street_name"
                           name="field_street_name">
                </div>
                <div class="elements">
                    <label for="email">Email</label>
                    <input type="text"
                           class=""
                           id="email"
                           name="field_email"
                           placeholder="ex: a.dupont@mail.com"
                           required>
                </div>
                <div class="elements">
                    <label for="phone">Téléphone</label>
                    <input type="text"
                           class=""
                           id="phone"
                           name="field_phone"
                           maxlength="10"
                           placeholder="ex: 04 10 10 10 10"
                           required>
                </div>
                <div class="elements">
                    <label for="firstname">Prénom</label>
                    <input type="text"
                           class=""
                           id="firstname"
                           name="field_firstname"
                           placeholder="ex: Alfred"
                           required>
                </div>
                <div class="elements">
                    <label for="lastname">Nom</label>
                    <input type="text"
                           class=""
                           id="lastname"
                           name="field_lastname"
                           placeholder="ex: Dupont"
                           required>
                </div>

            </fieldset>
            <div class="elements submit">
                <input type="submit">
            </div>
        </form>

    </section>
</main>
<script type="module" src="../assets/js/newCustomer.js"></script>

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

