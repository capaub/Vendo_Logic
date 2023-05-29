<?php

use DaBuild\Entity\User;

?>
<main class="Container_main Main CustomerContainer customerContainer">
    <h1 class="Main_title">B</h1>

    <section class="account_section">

        <div class="element submit">
            <button class="btnModifyAccount">Modifier</button>
        </div>


        <form class="Main_container"
              method="post"
              data-user-id="<?= /** @var User $user */
              $user->getId(); ?>">
            <input class="input-form"
                   type="text"
                   name="field_firstname"
                   id="firstname"
                   disabled
                   value="<?= $user->getFirstname(); ?>">
            <input class="input-form"
                   type="text"
                   name="field_lastname"
                   id="lastname"
                   disabled
                   value="<?= $user->getLastname(); ?>">
            <input class="input-form"
                   type="text"
                   name="field_email"
                   id="mail"
                   disabled
                   value="<?= $user->getEmail(); ?>">
            <select class="input-form select"
                    name="field_role"
                    disabled
                    id="role">

                <?php foreach (User::ROLE_CONF as $iRole => $aRole) : ?>

                    <option <?= $iRole == $user->getRole() ? 'selected="selected"' : '' ?>
                        value="<?= $iRole; ?>">
                        <?= $aRole['label']; ?>
                    </option>

                <?php endforeach; ?>

            </select>

            <div class="input-form">
                <?php if (!is_null($user->getConnectedAt())) : ?>
                    <p class="text"><?= $user->getConnectedAt()->format('Y-m-d'); ?></p>
                    <p class="text"><?= $user->getConnectedAt()->format('H:i:s'); ?></p>
                <?php endif; ?>
            </div>

<!--            <div>-->
<!--                <button class="save hidden">enregistrer</button>-->
<!---->
<!--                <button class="update">-->
<!--                    <span class="material-symbols-outlined">upgrade</span>-->
<!--                </button>-->
<!---->
<!--                <button class="delete">-->
<!--                    <span class="material-symbols-outlined">delete_sweep</span>-->
<!--                </button>-->
<!---->
<!--            </div>-->

        </form>
</main>