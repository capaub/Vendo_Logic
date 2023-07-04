
<main class="Container_main Main">

    <h1 class="Main_title">Machines</h1>

    <button class="btn_add_vending" data-text="Ajouter une machine"></button>
    <button class="btn_back_add_batch_vending_to_vendingList hidden" data-text="Retour"></button>
    <button class="btn_back_new_vending_to_vendingList hidden" data-text="Retour"></button>

    <section class="list_container vending_list_container">
        <?php include '_vendings.php'; ?>
    </section>

    <section class="vendingGrid hidden">
        <?php include 'vendingId.php'; ?>
    </section>

    <div class="container_new_vending_form hidden">
        <?php include '_addVending.php'; ?>
    </div>

    <div class="container_add_batch_form hidden">
        <?php include '_addBatchesToVending.php'; ?>
    </div>

    <script type="module" src="../public/assets/js/newVending.js"></script>
    <script type="module" src="../public/assets/js/showVending.js"></script>
    <script type="module" src="../public/assets/js/addBatchToVending.js"></script>

</main>