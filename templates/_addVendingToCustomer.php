<?php use DaBuild\Entity\Vending; ?>
<?php /** @var Vending $availableVending */
if (empty($availableVending)) : ?>
    <option>
        Aucuns D.A. disponible
    </option>
<?php else: ?>
    <fieldset class="padding">
        <legend>Ajouter une machine chez <?= $companyName ?></legend>
        <form method="POST"
              class="padding"
              data-customer-id="<?= $customerId ?>">
            <label for="vendings">Les distributeurs</label>
            <select name="field_vending_id" id="vendings">
                <?php foreach ($availableVending as $oVending) : ?>
                    <option value="<?= $oVending->getId(); ?>">
                        <?= '[ ' . $oVending->getBrand() . ' ]' . ' - ' . $oVending->getModel(); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div>
                <label for="vending_name">Attribuer un nom</label>
                <input type="text"
                       class=""
                       id="vending_name"
                       name="field_vending_name"
                       required>
                <button type="button"
                        class="addVending">enregistrer
                </button>
            </div>
        </form>
    </fieldset>
<?php endif; ?>