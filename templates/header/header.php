<?php

use DaBuild\Entity\User;

;?>

<header class="Header">
    <div class="Header_logo" ><img src="../assets/img/logo.svg" alt="logo Vendo Logic"></div>
    <form class="Header_search hidden">
        <label for="search">
            <input class="Header_search_field" type="search" id="search" placeholder="Recherche">
        </label>
    </form>
    <div class="Header_burger">
        <div class="Header_burgerIcon Icon isClosed">
            <span></span>
            <svg x="0" y="0" width="54px" height="54px" viewBox="0 0 54 54">
                <path d="M16.500,27.000 C16.500,27.000 24.939,27.000 38.500,27.000 C52.061,27.000 49.945,15.648 46.510,11.367 C41.928,5.656 34.891,2.000 27.000,2.000 C13.193,2.000 2.000,13.193 2.000,27.000 C2.000,40.807 13.193,52.000 27.000,52.000 C40.807,52.000 52.000,40.807 52.000,27.000 C52.000,13.000 40.837,2.000 27.000,2.000 "></path>
            </svg>
        </div>
    </div>
    <nav class="Header_topNav">
        <?php if(isset($_SESSION['user']) && $_SESSION['user'] instanceof User) : ?>
            <div class="Header_topNav_account">
                <div class="Header_topNav_user">
                    <p class="Header_topNav_user_name"><?= $_SESSION['user']->getFirstname().$_SESSION['user']->getLastname()?? '' ;?></p>
                    <p class="Header_topNav_user_role"><?= User::ROLE_CONF[$_SESSION['user']->getRole()]['label'] ?? '' ;?></p>
                </div>
            </div>
            <div class="Header_topNav_img"></div>

        <?php endif; ?>
    </nav>

    <?php include '_sidebar.php' ?>
</header>