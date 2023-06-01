<?php use DaBuild\Entity\Vending; ?>

<main class="Container_main Main">

    <h1 class="Main_title">Vending</h1>

    <div class="elements submit btnAddVending">
        <button>ajouter une machine</button>
    </div>
    <div class="elements submit hidden btnBackAddVendingToVendingList">
        <button>Retour</button>
    </div>
    <div class="elements submit hidden btnBackVendingToVendingList">
        <button>Retour</button>
    </div>

    <section class="list_container vendingListContainer">
        <ul class="grid_container">
            <li>Marque</li>
            <li>Model</li>
            <li>Nom</li>
            <li>Plateau max</li>
            <li>Spirale max</li>
        </ul>

        <?php if (empty($vending)) : ?>
            <ul class="grid_container">
                <p>Aucune machine à afficher</p>
            </ul>
        <?php else: ?>
            <div class="container_vending_list">
                <?php include '_vendings.php';?>
            </div>
        <?php endif; ?>

    </section>
<!--    <div class="containerBackgroundVending">-->
        <section class="vendingGrid hidden">
            <?php include 'vendingId.php'; ?>
        </section>
<!--    </div>-->
    <section class="new_vending_form hidden">
        <?php include '_addVending.php'; ?>
    </section>

    <section class="addBatchToVending hidden">
        <?php include '_addBatchesToVending.php'; ?>
    </section>


<script type="module" src="../assets/js/newVending.js"></script>
<script type="module" src="../assets/js/showVending.js"></script>
<script type="module" src="../assets/js/addBatchToVending.js"></script>

</main>