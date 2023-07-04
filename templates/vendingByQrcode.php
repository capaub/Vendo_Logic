<main class="Container_main Main">

    <h1 class="Main_title">Vending</h1>

    <button class="btn_add_vending hidden" data-text="Ajouter une machine"></button>
    <button class="btn_back_add_batch_vending_to_vendingList hidden" data-text="Retour"></button>
    <button class="btn_back_new_vending_to_vendingList hidden" data-text="Retour"></button>

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
                            <div class="batch_picture"></div>
                            <p class="location_identifier"
                               data-vending="<?= $_POST['vending_tags'] ?? ' ' ?>"
                               data-vending-id="<?= $vendingId; ?>"><?= $targetLocation ?></p>
                        </li>
                    <?php endfor; ?>
                </ul>
            <?php endfor; ?>

        <?php endif ?>
    </section>

    <section class="container_add_batch_form hidden">
        <?php include '_addBatchesToVending.php'; ?>
    </section>

</main>

<script type="module" src="../public/assets/js/showVending.js"></script>
<script type="module" src="../public/assets/js/addBatchToVending.js"></script>