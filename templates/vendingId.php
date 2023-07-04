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
