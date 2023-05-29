<main class="Container_main Main">

    <h1 class="Main_title">Vending</h1>

    <section class="hidden btnBackToVendingList">
        <div class="elements submit ">
            <button>Retour</button>
        </div>
    </section>

    <section class="list_container hidden">
        <div class="flex_column_container vendingListContainer">

            <ul class="grid_container">
                <li>Marque</li>
                <li>Model</li>
                <li>Nom</li>
                <li>Plateau max</li>
                <li>Spirale max</li>
            </ul>

            <?php use DaBuild\Entity\Vending;

            if (empty($vending)) : ?>
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
        </div>
    </section>


    <section class="vendingGrid">

        <?php if (isset($dataVendingStock, $nbVendingTray, $nbVendingSpiral, $vendingId)) : ?>


            <?php for ($i = 1; $i <= $nbVendingTray; $i++): ?>
                <ul class="plateau">
                    <?php for ($j = 1; $j <= $nbVendingSpiral; $j++): ?>
                        <?php $targetLocation = NUM_TO_ALPHA[$i] . $j; ?>
                        <li class="spiral"
                            data-product-barcode="<?php
                            if (isset($dataVendingStock[$targetLocation])) {
                                echo $dataVendingStock[$targetLocation]['barcode'];
                            } else {
                                echo '';
                            }; ?>">
                            <div class="batchPicture"></div>
                            <p class="locationIdentifier"
                               data-vending="<?= $_POST['vending_tags'] ?? ' ' ?>"
                               data-vending-id="<?= $vendingId; ?>"><?= $targetLocation ?></p>
                        </li>
                    <?php endfor; ?>
                </ul>
            <?php endfor; ?>

        <?php endif ?>
    </section>

    <section class="addBatchToVending hidden">
        <?php include '_addBatchesToVending.php'; ?>
    </section>

</main>

<script type="module" src="../assets/js/showVending.js"></script>
<script type="module" src="../assets/js/addBatchToVending.js"></script>