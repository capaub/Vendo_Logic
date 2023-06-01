<?php use DaBuild\Entity\User; ?>

<aside class="Container_sidebar Sidebar">
    <nav class="Sidebar_links">
<!--        <a href="?page=--><?php //= PAGE_ACCOUNT;?><!--" class="Sidebar_links_link">-->
        <div class="Sidebar_links_link_img"></div>
<!--        </a>-->
<!--        <a href="?page=--><?php //= PAGE_HOME;?><!--" class="Sidebar_links_link">Accueil</a>-->
        <?php if(isset($_SESSION['user']) && $_SESSION['user'] instanceof User) : ?>
<!--            <a href="?page=--><?php //= PAGE_ACCOUNT;?><!--" class="Sidebar_links_link">Mon compte</a>-->
            <a href="?page=<?= PAGE_CUSTOMERS;?>"
               class="Sidebar_links_link <?= empty($_GET['page']) || ($_GET['page'] !== PAGE_CUSTOMERS) ? '' : 'selected' ?>">Clients</a>
            <?php if ($_SESSION['user']->getRole() === User::ROLE_ADMIN): ?>
<!--                <a href="?page=--><?php //= PAGE_ADD_VENDING;?><!--"-->
<!--                   class="Sidebar_links_link --><?php //= empty($_GET['page']) || ($_GET['page'] !== PAGE_ADD_VENDING) ? '' : 'selected' ?><!--">Enrergistrer une machine</a>-->
                <a href="?page=<?= PAGE_VENDINGS;?>"
                   class="Sidebar_links_link <?= empty($_GET['page']) || ($_GET['page'] !== PAGE_VENDINGS) ? '' : 'selected' ?>">Machines</a>
                <a href="?page=<?= PAGE_STOCK;?>"
                   class="Sidebar_links_link <?= empty($_GET['page']) || ($_GET['page'] !== PAGE_STOCK) ? '' : 'selected' ?>">Stock</a>
<!--                <a href="?page=--><?php //= PAGE_CREATE_USER;?><!--" class="Sidebar_links_link">Créer un utilisateur</a>-->
                <a href="?page=<?= PAGE_USERS;?>"
                   class="Sidebar_links_link <?= empty($_GET['page']) || ($_GET['page'] !== PAGE_USERS) ? '' : 'selected' ?>">Mes utilisateurs</a>
            <?php endif; ?>
        <?php endif; ?>

        <?php if(empty($_SESSION['user'])) : ?>
            <a href="?page=<?= PAGE_REGISTER;?>" class="Sidebar_links_link">register</a>
        <?php endif; ?>
    </nav>
</aside>