
<ul class="grid_container list_stock" data-barcode="<?= $sBarcode ?>">
    <li class="batch_info"><p><?= $sBarcode; ?></p></li>

    <li class="batch_info">
        <?php if ($aGoods['selectBatch']) : ?>
            <select name="Batch" id="Batch" class="date select_dlc_batch">
                <?php foreach ($aGoods['batchOptions'] as $iBatchId => $sDlc) : ?>
                    <option value="<?= $iBatchId; ?>"><?= $aGoods['batchOptions'][$iBatchId]; ?></option>
                <?php endforeach; ?>
            </select>
        <?php else : ?>
            <p><?= current($aGoods)['dlc'] ?? ''; ?></p>
        <?php endif; ?>
    </li>
    <?php $selectedBatch = reset($aGoods); ?>

    <li class="batch_info quantity">
        <p><?= $selectedBatch['quantity'] ?? ''; ?></p>
    </li>
    <li class="batch_info updated_at">
        <div class="updated_at_date"><em><?= $selectedBatch['updated_at_date'] ?? ''; ?></em></div>
        <div class="updated_at_time"><em><?= $selectedBatch['updated_at_time'] ?? ''; ?></em></div>
    </li>

    <li class="batch_info" data-product-barcode="<?= $selectedBatch['barcode'] ?? '' ?>">
        <div class="batchPicture"></div>
    </li>

</ul>
