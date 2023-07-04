<?php /** @var Customer $oCustomer */

use DaBuild\Entity\Customer;

foreach ($customer as $oCustomer) : ?>
    <section class="Main_customers_customer Customer <?= $customerStatus[$oCustomer->getId()] ?? '' ?> ajaxCustomer"
             data-customer-id="<?= $oCustomer->getId(); ?>"
             data-company-name="<?= $oCustomer->getCompanyName(); ?>">
        <h3 class="Customer_name" data-text="Attribuer une machine"><?= strtoupper($oCustomer->getCompanyName()); ?>
            <span>infos</span>
        </h3>
        <button class="btn_add_vending_to_customer" data-text="Attribuer une machine"
                title="Attribuer une machine"></button>
        <div class="Customer_container">
            <?php if (isset($vending[$oCustomer->getId()])) : ?>
                <div class="Customer_container_vendings <?= $customerStatus[$oCustomer->getId()] ?? 'hidden' ?>">
                    <?php foreach ($vending[$oCustomer->getId()] as $oVending) : ?>
                        <div class="Customer_vendings_vending Vending <?= $status[$oVending->getId()] ?? 'hidden'; ?>"
                             data-vending-id="<?= $oVending->getId() ?>">
                            <img class="Vending_img" src="../public/assets/img/vending/vending.svg"
                                 alt="illustratoin d'un distributeur automatique">
                            <div class="Vending_footer">
                                <p class="Vending_footer_name"><?= $oVending->getName() ?? ''; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="Customer_container_infos">
                <div class="Customer_container_infos_contact">
                    <div class="Customer_container_infos_contact_group">
                        <h3 class="Customer_container_infos_contact_group_title">Contact</h3>
                        <ul class="Customer_container_infos_contact_group_ul">
                            <li><?= $oCustomer->getPhone(); ?></li>
                            <li><?= $oCustomer->getFirstname() . ' ' . $oCustomer->getLastname(); ?></li>
                            <li><?= $oCustomer->getEmail(); ?></li>
                        </ul>
                    </div>
                    <div class="Customer_container_infos_contact_group">
                        <h3 class="Customer_container_infos_contact_group_title">Horaires</h3>
                        <ul class="Customer_container_infos_contact_group_ul">
                            <li>lundi-vendredi : 8h00-16h00</li>
                        </ul>
                    </div>
                </div>
                <div class="Customer_container_infos_maps">
                    <img class="Customer_container_infos_maps_img" src="../public/assets/img/maps.jpg" alt="">
                </div>
            </div>
        </div>
    </section>

<?php endforeach; ?>