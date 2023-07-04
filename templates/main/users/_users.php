<ul class="grid_container">
    <li>Prénom</li>
    <li>Nom</li>
    <li>Mail</li>
    <li>Rôle</li>
    <li>Connexion</li>
    <li>Modifier</li>
</ul>
<?php if (empty($user)) : ?>
    <div class="grid_container">
        <p>Aucuns utilisateurs enregistré</p>
    </div>
<?php endif; ?>

<?php foreach ($user as $oUser) : ?>
    <?php include 'user.php' ?>
<?php endforeach; ?>