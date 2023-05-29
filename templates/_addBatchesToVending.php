<?php use DaBuild\Repository\GoodsRepository; ?>

<form method="POST"
      class="batch_form form_container"
      data-vending-id="<?= $_POST['vending_id'] ?? ''?>">

    <div class="elements submit">
        <button class="close">X</button>
    </div>

    <fieldset data-vending-tags="<?= $_POST['vending_tags'] ?? ''?>" class="fieldset">
        <legend>
            <?= $_POST['vending_tags'] ?? ''?>
        </legend>
        <?php if (isset($batch)) : ?>
            <div class="elements">
                <label for="batch">Produits</label>
                <select name="field_batch" id="batch">
                    <?php foreach ($batch as $oBatch) : ?>
                        <option value="<?= $oBatch->getId() ?>">
                            <?= (GoodsRepository::find($oBatch->getGoodsId()))->getBrand(); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <div class="elements">
            <label for="quantity">Quantité</label>
            <input type="number"
                   name="field_quantity"
                   id="quantity">
        </div>

        <div class="elements">
            <label for="location">Emplacement</label>
            <input type="text"
                   name="field_location"
                   id="location"
                <?php if (isset($_POST['location'])) : ?>
                    value="<?= $_POST['location']; ?>"
                <?php endif; ?>>
        </div>

    </fieldset>

    <div class="elements submit">
        <input type="submit" class="addBatchSubmit">
    </div>

</form>
