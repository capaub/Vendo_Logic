<?php use DaBuild\Entity\User; ?>

<form method="POST"
      class="form_container new_user_form">

    <div class="elements submit">
        <button class="close closeNewUserForm">X</button>
    </div>

    <fieldset class="fieldset">
        <legend>Renseignements utilisateur</legend>

        <div class="elements">
            <label for="firstname">Prénom</label>
            <input required type="text" id="firstname" name="field_firstname">
        </div>

        <div class="elements">
            <label for="lastname">Nom</label>
            <input required type="text" id="lastname" name="field_lastname">
        </div>

        <div class="elements">
            <label for="email">Email</label>
            <input required type="email" id="email" name="field_email">
        </div>

        <div class="elements">
            <label for="role">Role</label>
            <select name="field_role" id="role">
                <?php foreach (User::ROLE_CONF as $key => $value) : ?>
                    <option value="<?= $key ?>"><?= $value['label'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

    </fieldset>

    <div class="elements submit">
        <input type="submit" class="newUserSubmit">
    </div>

</form>
