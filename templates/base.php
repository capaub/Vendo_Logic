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
    <title><?= $seo_title ?? '' ?> - VendoLogic</title>
    <meta name="description" content="Site d'aide à la gestion d'un parc de distributeur automatique">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $oDebugbarRenderer->renderHead() ?>
    <link rel="stylesheet" href="../public/assets/css/global.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"/>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0"/>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0"/>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0"/>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0"/>
</head>
<body>

<?php include 'header/header.php'; ?>


<div class="Container">
    <?php if (file_exists(__DIR__ . '/' . $sView)) {
        include $sView;
    } else {
        throw new \Exception('templates not found :' . __DIR__ . '/' . $sView);
    } ?>
</div>

<?php include 'footer/footer.php'; ?>

<?= $oDebugbarRenderer->render() ?>
<script type="module" src="../public/assets/js/global.js"></script>
</body>
</html>