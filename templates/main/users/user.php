<?php use DaBuild\Entity\User; ?>


<form class="Main_container grid_container"
      method="post"
      data-user-id="<?= /** @var User $oUser */
      $oUser->getId(); ?>">
    <input class="input-form"
           type="text"
           name="field_firstname"
           id="firstname"
           disabled
           value="<?= $oUser->getFirstname(); ?>">
    <input  class="input-form"
            type="text"
            name="field_lastname"
            id="lastname"
            disabled
            value="<?= $oUser->getLastname(); ?>">
    <input  class="input-form"
            type="text"
            name="field_email"
            id="mail"
            disabled
            value="<?= $oUser->getEmail(); ?>">
    <select class="input-form select"
            name="field_role"
            disabled
            id="role">
        <?php foreach (User::ROLE_CONF as $iRole => $aRole) : ?>

            <option <?= $iRole == $oUser->getRole() ? 'selected="selected"' : '' ?>
                value="<?= $iRole; ?>">
                <?= $aRole['label']; ?>
            </option>
        <?php endforeach; ?>
    </select>

    <div class="input-form">
        <?php if (!is_null($oUser->getConnectedAt())) : ?>
        <p class="text"><?= $oUser->getConnectedAt()->format('Y-m-d'); ?></p>
        <p class="text"><?= $oUser->getConnectedAt()->format('H:i:s'); ?></p>
        <?php endif; ?>
    </div>

    <div>
        <button class="save hidden">enregistrer</button>
        <button class="update">
            <span class="material-symbols-outlined">upgrade</span>
        </button>
        <button class="delete">
            <span class="material-symbols-outlined">delete_sweep</span>
        </button>
    </div>
</form>