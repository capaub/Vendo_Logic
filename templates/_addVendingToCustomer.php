<?php use DaBuild\Entity\Vending; ?>


<form method="POST"
      class="form_container"
      data-customer-id="<?= $customerId ?>">

    <div class="elements submit">
        <button class="close closeAddVendingForm">X</button>
    </div>

    <fieldset class="padding">
        <legend><span class="company_name"><?= $companyName ?></span></legend>

        <div class="elements">
            <label for="vendings">Les distributeurs</label>
            <select name="field_vending_id" id="vendings">
                <?php /** @var Vending $availableVending */
                if (empty($availableVending)) : ?>
                    <option>
                        Aucuns D.A. disponible
                    </option>
                <?php else: ?>
                    <?php foreach ($availableVending as $oVending) : ?>
                        <option value="<?= $oVending->getId(); ?>">
                            <?= '[ ' . $oVending->getBrand() . ' ]' . ' - ' . $oVending->getModel(); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="elements">
            <label for="vending_name">Attribuer un nom</label>
            <input type="text"
                   class=""
                   id="vending_name"
                   name="field_vending_name"
                   required>
        </div>
    </fieldset>
    <div class="elements submit">
        <input type="submit" class="addVending">
    </div>
</form>