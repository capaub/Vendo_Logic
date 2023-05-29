<?php

// Require the Composer autoloader, if not already loaded
require '../vendor/autoload.php';

use DebugBar\StandardDebugBar;

$oDebugbar = new StandardDebugBar();
$oDebugbarRenderer = $oDebugbar->getJavascriptRenderer('../vendor/maximebf/debugbar/src/DebugBar/Resources');

$oDebugbar["messages"]->addMessage('hello world!');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $seo_title ?? '' ?> - VB</title>
    <meta name="description" content="super blog">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $oDebugbarRenderer->renderHead() ?>
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0"/>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0"/>
</head>
<body>

<?php include 'header/header.php'; ?>


<div class="Container">
    <?php include 'sidebar/_sidebar.php'; ?>

    <?php if (file_exists('../templates/' . $sView)) {
        include $sView;
    } ?>
</div>

<?php include 'footer/footer.php'; ?>

<?= $oDebugbarRenderer->render() ?>
<script type="module" src="../assets/js/global.js"></script>
</body>
</html>