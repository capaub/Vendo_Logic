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

        <?php include '_customers.php'; ?>
    </div>
    <?php endif; ?>

    <div class="add_vending_form hidden addVendingContainer ">
        <?php include '_addVendingToCustomer.php'; ?>
    </div>



</main>
<script type="module" src="../assets/js/addVendingToCustomer.js"></script>

<script type="module" src="../assets/js/showNewCustomerForm.js"></script>

<script type="module" src="../assets/js/newCustomer.js"></script>