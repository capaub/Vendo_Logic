<?php use DaBuild\Entity\User
    /**@param User $oUser */ ; ?>

<ul class="Main_container Main_container grid_container">
    <li>Prénom</li>
    <li>Nom</li>
    <li>Mail</li>
    <li>Role</li>
    <li>Connecté le</li>
    <li>Modifier / supprimer</li>
</ul>
<?php if (empty($user)) : ?>
    <ul>
        <li>Aucuns utilisateurs à afficher</li>
    </ul>
<?php endif ; ?>

<?php foreach ($user as $oUser) : ?>
    <?php include 'user.php' ?>
<?php endforeach; ?>