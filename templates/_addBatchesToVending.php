<?php use DaBuild\Repository\GoodsRepository; ?>


<form method="POST"
      class="add_batch_form form_container"
      data-vending-id="<?= $_POST['vending_id'] ?? ''?>">

    <button class="close closeAddVendingForm">X</button>


    <fieldset data-vending-tags="<?= $_POST['vending_tags'] ?? ''?>" class="fieldset">
<!--        <legend>-->
<!--            --><?php //= $_POST['vending_tags'] ?? ''?>
<!--        </legend>-->
        <?php if (isset($batch)) : ?>
            <div class="elements">
                <select name="field_batch" id="batch" required="required">
                    <?php foreach ($batch as $key => $oBatch) : ?>
                        <option value="<?= $oBatch->getId() ?>"  <?= ($batch[$key] === 1) ? "selected" : ""  ?>>
                            <?= (GoodsRepository::find($oBatch->getGoodsId()))->getBrand(); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="batch">Produits</label>
            </div>
        <?php endif; ?>

        <div class="elements">
            <input type="number"
                   name="field_quantity"
                   id="quantity"
                   required="required">
            <label for="quantity">Quantité</label>
        </div>

        <div class="elements">
            <input type="text"
                   name="field_location"
                   id="location"
                <?php if (isset($_POST['location'])) : ?>
                    value="<?= $_POST['location']; ?>"
                <?php endif; ?> readonly>
            <label for="location">Emplacement</label>
        </div>

    </fieldset>


        <input type="submit" class="add_batch_submit">


</form>