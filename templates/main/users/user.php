<form class="grid_container_form grid_container"
      method="post"
      data-user-id="<?= $oUser->getId(); ?>">
    <input class="input-form"
           type="text"
           name="field_firstname"
           id="firstname"
           disabled
           value="<?= $oUser->getFirstname(); ?>">
    <input class="input-form"
           type="text"
           name="field_lastname"
           id="lastname"
           disabled
           value="<?= $oUser->getLastname(); ?>">
    <input class="input-form"
           type="email"
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

    <div>
        <?php if (!is_null($oUser->getConnectedAt())) : ?>
            <p class="text"><?= $oUser->getConnectedAt()->format('Y-m-d'); ?></p>
            <p class="text"><?= $oUser->getConnectedAt()->format('H:i:s'); ?></p>
        <?php endif; ?>
    </div>

    <div class="buttons_actions_container">
        <button class="save hidden">
            <span class="material-symbols-outlined">save_as</span>
        </button>
        <button class="cancel hidden">
            <span class="material-symbols-outlined">cancel</span>
        </button>
        <button class="update">
            <span class="material-symbols-outlined">edit</span>
        </button>
        <button class="delete">
            <span class="material-symbols-outlined">delete_forever</span>
        </button>
    </div>
</form>