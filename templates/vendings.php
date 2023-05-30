<?php use DaBuild\Entity\Vending; ?>

<main class="Container_main Main">

    <h1 class="Main_title">Vending</h1>

    <div class="elements submit hidden btnBackToVendingList">
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

            <?php /** @var Vending $oVending */
            foreach ($vending as $oVending) : ?>
                <ul class="grid_container vending" data-vending-id="<?= $oVending->getId(); ?>">
                    <li data-brand="<?= $oVending->getBrand(); ?>">
                        <?= $oVending->getBrand(); ?>
                    </li>
                    <li data-model="<?= $oVending->getModel(); ?>">
                        <?= $oVending->getModel(); ?>
                    </li>
                    <li data-name="<?= $oVending->getName(); ?>">
                        <?= $oVending->getName(); ?>
                    </li>
                    <li data-tray="<?= $oVending->getNbMaxTray(); ?>">
                        <?= $oVending->getNbMaxTray(); ?>
                    </li>
                    <li data-spiral="<?= $oVending->getNbMaxSpiral(); ?>">
                        <?= $oVending->getNbMaxSpiral(); ?>
                    </li>
                </ul>
            <?php endforeach; ?>
        <?php endif; ?>

    </section>
<!--    <div class="containerBackgroundVending">-->
        <section class="vendingGrid hidden">
            <?php include 'vendingId.php'; ?>
        </section>
<!--    </div>-->

    <section class="addBatchToVending hidden">
        <?php include '_addBatchesToVending.php'; ?>
    </section>

</main>

<script type="module" src="../assets/js/showVending.js"></script>
<script type="module" src="../assets/js/addBatchToVending.js"></script>
