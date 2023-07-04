<main class="Container_main Main CustomerContainer customerContainer">
    <h1 class="Main_title">Clients</h1>

    <button class="btnAddCustomer" data-text="Nouveau client" title="Nouveau client"></button>

    <?php if (empty($customer)) : ?>

        <div class="grid_container">
            <p>Aucun client enregistré</p>
        </div>

    <?php else : ?>
        <div class="Main_customers">
            <?php include '_customers.php'; ?>
        </div>
    <?php endif; ?>

    <div class="container_add_vending_form hidden">
        <?php include '_addVendingToCustomer.php'; ?>
    </div>

    <script type="module" src="../public/assets/js/SnapShotForm.js"></script>
    <script type="module" src="../public/assets/js/addVendingToCustomer.js"></script>
    <script type="module" src="../public/assets/js/showNewCustomerForm.js"></script>
    <script type="module" src="../public/assets/js/newCustomer.js"></script>
    <script type="module" src="../public/assets/js/generateCustomerVending.js"></script>
    <script type="module" src="../public/assets/js/sortCustomer.js"></script>

</main>