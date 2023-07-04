<?php use DaBuild\Entity\User; ?>

<aside class="Container_sidebar Sidebar">
    <nav class="Sidebar_links">

        <?php if (isset($_SESSION['user']) && $_SESSION['user'] instanceof User) : ?>

            <?php if (($_SESSION['user']->getRole() === User::ROLE_ADMIN)
                || ($_SESSION['user']->getRole() === User::ROLE_SUPPLIER)): ?>
                <a href="?page=<?= PAGE_CUSTOMERS; ?>"
                   class="Sidebar_links_link <?= empty($_GET['page']) || ($_GET['page'] !== PAGE_CUSTOMERS) ? '' : 'selected' ?>">Clients</a>
            <?php endif; ?>

            <?php if ($_SESSION['user']->getRole() === User::ROLE_ADMIN): ?>

                <a href="?page=<?= PAGE_VENDINGS; ?>"
                   class="Sidebar_links_link <?= empty($_GET['page']) || ($_GET['page'] !== PAGE_VENDINGS) ? '' : 'selected' ?>">Machines</a>
                <a href="?page=<?= PAGE_STOCK; ?>"
                   class="Sidebar_links_link <?= empty($_GET['page']) || ($_GET['page'] !== PAGE_STOCK) ? '' : 'selected' ?>">Stock</a>

                <a href="?page=<?= PAGE_USERS; ?>"
                   class="Sidebar_links_link <?= empty($_GET['page']) || ($_GET['page'] !== PAGE_USERS) ? '' : 'selected' ?>">Utilisateurs</a>
            <?php endif; ?>

            <a href="?page=<?= PAGE_LOGOUT; ?>" class="Sidebar_links_link">Deconnexion</a>

        <?php endif; ?>

    </nav>
</aside>