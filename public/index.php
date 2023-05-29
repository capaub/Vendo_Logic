<?php

require '../vendor/autoload.php';

session_start();

require_once '../config/config.php';

if (!isset($_SESSION['id'])) {
    $_SESSION['id'] = uniqid();
    $_SESSION['flashes'] = [];
}

$sPage = $_GET['page'] ?? PAGE_HOME;

if (!array_key_exists($sPage,ROUTING)) {
    $sPage = PAGE_HOME;
}

[$sClass, $sFunction] = explode('::', ROUTING[$sPage]);
echo (new $sClass())->$sFunction();