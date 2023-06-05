<?php use DaBuild\Entity\Vending; ?>

<main class="Container_main Main">

    <h1 class="Main_title">Machines</h1>

<!--    <div class="elements submit">-->
        <button class="btnAddVending" data-text="Ajouter une machine"></button>
<!--    </div>-->
<!--    <div class="elements submit hidden">-->
        <button class="btnBackAddVendingToVendingList hidden" data-text="Retour"></button>
<!--    </div>-->
<!--    <div class="elements submit hidden">-->
        <button class="btnBackVendingToVendingList hidden" data-text="Retour"></button>
<!--    </div>-->

    <section class="list_container vendingListContainer">

                <?php include '_vendings.php';?>

    </section>
<!--    <div class="containerBackgroundVending">-->
        <section class="vendingGrid hidden">
            <?php include 'vendingId.php'; ?>
        </section>
<!--    </div>-->

    <div class="container_new_vending_form hidden">
        <?php include '_addVending.php'; ?>
    </div>

    <div class="container_add_batch_form hidden">
        <?php include '_addBatchesToVending.php'; ?>
    </div>



<script type="module" src="../assets/js/newVending.js"></script>
<script type="module" src="../assets/js/showVending.js"></script>
<script type="module" src="../assets/js/addBatchToVending.js"></script>

</main>