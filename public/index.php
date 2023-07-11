<?php

require '../vendor/autoload.php';

session_start();

require_once '../config/config.php';

if (!isset($_SESSION['id'])) {
    $_SESSION['id'] = uniqid();
    $_SESSION['flashes'] = [];
}

$sPage = $_GET['page'] ?? PAGE_LOGIN;

if (!array_key_exists($sPage, ROUTING)) {
    $sPage = PAGE_CUSTOMERS;
}

[$sClass, $sFunction] = explode('::', ROUTING[$sPage]);
echo (new $sClass())->$sFunction();