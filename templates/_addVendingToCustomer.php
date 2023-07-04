<?php use DaBuild\Entity\Vending; ?>


<form method="POST"
      class="form_container add_vending_form"
      data-customer-id="<?= $customerId ?>">

    <button class="close closeAddVendingForm">X</button>

    <fieldset class="fieldset">
        <legend><span class="company_name"><?= $companyName ?></span></legend>

        <div class="elements">
            <select name="field_vending_id" id="vendings" required="required">
                <?php /** @var Vending $availableVending */
                if (empty($availableVending)) : ?>
                    <option>
                        Aucuns D.A. disponible
                    </option>
                <?php else: ?>
                    <option value="">
                        Choisissez une machine
                    </option>
                    <?php foreach ($availableVending as $oVending) : ?>
                        <option value="<?= $oVending->getId(); ?>">
                            <?= '[ ' . $oVending->getBrand() . ' ]' . ' - ' . $oVending->getModel(); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <label for="vendings">Les distributeurs</label>
        </div>
        <div class="elements">
            <input type="text"
                   class=""
                   id="vending_name"
                   name="field_vending_name"
                   required="required">
            <label for="vending_name">Attribuer un nom</label>
        </div>
    </fieldset>

    <input type="submit" class="addVending">

</form>