
<?php /** @var Vending $oVending */

use DaBuild\Entity\Vending;

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