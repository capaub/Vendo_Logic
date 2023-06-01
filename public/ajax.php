<?php

use DaBuild\Controller\BatchController;
use DaBuild\Controller\CompanyController;
use DaBuild\Controller\CustomerController;
use DaBuild\Controller\DefaultController;
use DaBuild\Controller\VendingStockController;
use DaBuild\Controller\VendingPerCustomerController;
use DaBuild\Controller\UserController;
use DaBuild\Controller\VendingController;
use DaBuild\Repository\BatchRepository;

require '../vendor/autoload.php';
session_start();
require_once '../config/config.php';

//if (isset($_POST['context'])) {
//    return match ($_POST['context']) {
//        AJAX_NEW_USER                   => (new CompanyController)->createUser(),
//        AJAX_USER_UPDATE                => (new UserController)->updateUser(),
//        AJAX_USER_REFRESH               => (new UserController)->refreshUser(),
//        AJAX_USER_DELETE                => (new UserController)->deleteUser(),
//        AJAX_SHOW_VENDING               => (new VendingController)->buildVending(),
//        AJAX_SHOW_CONTAINER_ADD_VENDING => (new VendingController)->showAvailableVending(),
//        AJAX_ADD_VENDING_TO_CUSTOMER    => (new VendingPerCustomerController)->addVendingToCustomer(),
////        AJAX_ADD_STOCK_TO_VENDING       => (new VendingStockController)->addStockToVending(),
//        AJAX_SHOW_BATCH                 => (new BatchController)->getBatch(),
//        AJAX_NEW_BATCH                  => (new BatchController)->createBatch(),
//        AJAX_NEW_CUSTOMER               => (new CustomerController)->addCustomer(),
//        AJAX_BACK_TO_CUSTOMER           => (new DefaultController)->showCustomers(),
//        default => "Context inconnu"
//    };
//}

if (isset($_POST['context'])){
    switch ($_POST['context']){
        case AJAX_NEW_USER:
            echo (new CompanyController)->createUser();
            break;
        case AJAX_USER_UPDATE:
            echo (new UserController)->updateUser();
            break;
        case AJAX_USER_REFRESH:
            echo (new UserController)->refreshUser();
            break;
        case AJAX_USER_DELETE:
            echo (new UserController)->deleteUser();
            break;
        case AJAX_SHOW_VENDING:
            echo (new VendingController)->buildVending();
            break;
        case AJAX_SHOW_CONTAINER_ADD_VENDING:
            echo (new VendingController)->showAvailableVending();
            break;
        case AJAX_ADD_VENDING_TO_CUSTOMER:
            echo (new VendingPerCustomerController)->addVendingToCustomer();
            break;
        case AJAX_ADD_STOCK_TO_VENDING:
            (new VendingStockController)->addStockToVending();
            break;
        case AJAX_SHOW_BATCH_FOR_VENDING:
            echo (new BatchController)->getAllBatch();
            break;
        case AJAX_NEW_BATCH:
            echo (new BatchController)->createBatch();
            break;
        case AJAX_CHANGE_BATCH:
            echo (new BatchController)->getBatchDataChangeAjax();
            break;
        case AJAX_NEW_CUSTOMER:
            echo (new CustomerController)->addCustomer();
            break;
        case AJAX_BACK_TO_CUSTOMER:
            echo (new DefaultController)->showCustomers();
            break;
        case AJAX_NEW_VENDING:
            echo (new VendingController())-> createVending();
            break;
    }
}
