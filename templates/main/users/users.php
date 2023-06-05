

<main class="Main UsersContainer">

    <div class="containerBlur">
        <h1 class="Main_title">Mes utilisateurs</h1>

        <div class="elements submit">
            <button class="btnAddUser" data-text="Ajouter un utilisateur"></button>
        </div>

        <section class="list_container user">
            <?php include '_users.php' ?>
        </section>
    </div>

    <div class="container_new_user_form hidden">
        <?php include '_createUser.php' ?>
    </div>

</main>

<script type="module" src="../assets/js/newUser.js"></script>
<script type="module" src="../assets/js/UpdateUser.js"></script>
