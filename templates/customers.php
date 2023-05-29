<?php use DaBuild\Entity\Customer; ?>

<main class="Container_main Main CustomerContainer customerContainer">
    <h1 class="Main_title">Tous les clients</h1>

    <div class="element submit">
        <button class="btnAddCustomer">Enregistrer un client</button>
    </div>

    <?php if (empty($customer)) : ?>

    <div class="grid_container">
        <p>Aucun client enregistré</p>
    </div>


    <?php else : ?>
    <div class="Main_customers">

        <?php /** @var Customer $oCustomer */
        foreach ($customer as $oCustomer) : ?>
            <section class="Main_customers_customer Customer alert ajaxCustomer"
                     data-customer-id="<?= $oCustomer->getId(); ?>"
                     data-company-name="<?= $oCustomer->getCompanyName(); ?>">
                <h3 class="Customer_name"><?= $oCustomer->getCompanyName(); ?><span>infos</span></h3>
                <div class="Customer_container">
                    <div class="Customer_container_vendings">
                        <?php if (isset($vending[$oCustomer->getId()])) : ?>
                            <?php foreach ($vending[$oCustomer->getId()] as $oVending) : ?>
                                <div class="Customer_vendings_vending Vending">
                                    <img class="Vending_img" src="../assets/img/vending/vending.svg" alt="">
                                    <p class="Vending_tagsAlert">OK</p>
                                    <div class="Vending_footer">
                                        <p class="Vending_footer_name"><?= $oVending->getName() ?? ''; ?></p>
<!--                                        <p class="Vending_footer_type">--><?php //= '[ ' . $oVending->getBrand() . ' ] - ' . $oVending->getModel(); ?><!--</p>-->
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="Customer_container_infos">
                        <div class="Customer_container_infos_contact">
                            <h3 class="Customer_container_infos_contact_title">Contact</h3>
                            <ul class="Customer_container_infos_contact_ul">
                                <li><?= $oCustomer->getPhone(); ?></li>
                                <li><?= $oCustomer->getFirstname() . ' ' . $oCustomer->getLastname(); ?></li>
                                <li><?= $oCustomer->getEmail(); ?></li>
                            </ul>
                            <h3 class="Customer_container_infos_contact_title">Horaires</h3>
                            <ul class="Customer_container_infos_contact_ul">
                                <li>lundi-vendredi : 8h00-16h00</li>
                            </ul>
                        </div>
                        <div class="Customer_container_infos_maps">
                            <img class="Customer_container_infos_maps_img" src="../assets/img/maps.jpg" alt="">
<!--                            <p class="Customer_container_infos_maps_address">--><?php //= $oCustomer->getAddress() . ', ' . $oCustomer->getPostalCode(); ?><!--</p>-->
                        </div>
                    </div>
                </div>
            </section>
        <?php endforeach; ?>

        <?php endif; ?>

        <section class="Main_customers_customer Customer hidden padding addVendingContainer">
            <?php include '_addVendingToCustomer.php'; ?>
        </section>

    </div>

</main>
<script type="text/javascript" src="../assets/js/addVendingToCustomer.js"></script>

<script type="module" src="../assets/js/showNewCustomerForm.js"></script>
