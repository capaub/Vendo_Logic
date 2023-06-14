<?php use DaBuild\Entity\User; ?>

<form method="POST"
      class="form_container new_user_form">

<!--    <div class="elements submit">-->
        <button class="close closeNewUserForm">X</button>
<!--    </div>-->

    <fieldset class="fieldset">
        <legend>Renseignements utilisateur</legend>

        <div class="elements">
            <input required type="text" id="firstname" name="field_firstname">
            <label for="firstname">Prénom</label>
        </div>

        <div class="elements">
            <input required type="text" id="lastname" name="field_lastname">
            <label for="lastname">Nom</label>
        </div>

        <div class="elements">
            <input required type="email" id="email" name="field_email">
            <label for="email">Email</label>
        </div>

        <div class="elements">
            <select name="field_role" id="role">
                <?php foreach (User::ROLE_CONF as $key => $value) : ?>
                    <option value="<?= $key ?>" <?= ($key == User::ROLE_SUPPLIER) ? "selected" : ""  ?>><?= $value['label'] ?></option>
                <?php endforeach; ?>
            </select>
            <label for="role">Role</label>
        </div>

    </fieldset>

<!--    <div class="elements submit">-->
        <input type="submit" class="newUserSubmit">
<!--    </div>-->

</form>
