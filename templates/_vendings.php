<ul class="grid_container">
    <li>Marque</li>
    <li>Model</li>
    <li>Nom</li>
    <li>Plateau max</li>
    <li>Spirale max</li>
</ul>

<?php if (empty($vending)) : ?>
    <ul class="grid_container">
        <p>Aucune machine à afficher</p>
    </ul>
<?php else: ?>

    <?php foreach ($vending as $oVending) : ?>
        <ul class="grid_container vending" data-vending-id="<?= $oVending->getId(); ?>">
            <li data-brand="<?= $oVending->getBrand(); ?>">
                <?= strtoupper($oVending->getBrand()); ?>
            </li>
            <li data-model="<?= $oVending->getModel(); ?>">
                <?= strtoupper($oVending->getModel()); ?>
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