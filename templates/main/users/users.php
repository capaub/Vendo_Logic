

<main class="Main UsersContainer">

    <div class="containerBlur">
        <h1 class="Main_title">Tous les utilisateurs</h1>

        <div class="elements submit">
            <button class="btnAddUser">Ajouter un utilisateur</button>
        </div>

        <section class="list_container user">
            <?php include '_users.php' ?>
        </section>
    </div>

    <section class="new_user_section hidden">
        <?php include '_createUser.php' ?>
    </section>

</main>

<script type="text/javascript" src="../../../assets/js/UpdateUser.js"></script>
<script type="module" src="../../../assets/js/newUser.js"></script>
