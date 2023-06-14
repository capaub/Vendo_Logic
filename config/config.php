<?php

date_default_timezone_set('Europe/Paris');

define('ENV', ($_SERVER['HTTP_HOST'] === 'localhost') ? 'development' : 'production');

if (ENV !== 'development') {
    ini_set('display_errors', false);
}

const DB_NAME = 'vendo_logic';
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PWD = '';

const DIR_PRODUCTS_IMG = '../assets/img/products';
const DIR_QR_VENDING_IMG = '../assets/img/qrcode/vending';

const DIR_QR_IMG = '../assets/img/qrcode';
const DIR_QR_BATCH_IMG = '../assets/img/qrcode/batch';
const PREFIX_BATCH_IMG = 'VENLO_';
const PREFIX_VENDING_QRCODE = 'VENDING_';
const PREFIX_BATCH_QRCODE = 'BATCH_';


const NUM_TO_ALPHA = [
    1   => 'A',
    2   => 'B',
    3   => 'C',
    4   => 'D',
    5   => 'E',
    6   => 'F',
    7   => 'G',
    8   => 'H',
    9   => 'I',
    10  => 'J',
    11  => 'K',
    12  => 'L',
    13  => 'M',
    14  => 'N',
    15  => 'O',
    16  => 'P',
    17  => 'Q',
    18  => 'R',
    19  => 'S',
    20  => 'T',
    21  => 'U',
    22  => 'V',
    23  => 'W',
    24  => 'X',
    25  => 'Y'
];

const PAGE_HOME = 'home';
const PAGE_LOGIN = 'login';
const PAGE_LOGOUT = 'logout';
const PAGE_REGISTER = 'register';
const PAGE_CUSTOMERS = 'customers';
const PAGE_STOCK = 'stock';




const PAGE_USERS = 'users';
const PAGE_ADD_VENDING = 'addVending';
const PAGE_SAVE_VENDING = 'saveVending';
const PAGE_VENDINGS = 'vendings';

const PAGE_ACCOUNT = 'account';



const AJAX_NEW_USER = 'newUser';
const AJAX_USER_DELETE = 'usersDelete';
const AJAX_USER_UPDATE = 'usersUpdate';
const AJAX_USER_REFRESH = 'usersRefresh';


const AJAX_NEW_CUSTOMER = 'newCustomer';
const AJAX_BACK_TO_CUSTOMER = 'backToCustomers';
const AJAX_SHOW_CONTAINER_ADD_VENDING = 'showContainerAddVending';
const AJAX_ADD_VENDING_TO_CUSTOMER = 'addVendingToCustomer';


const AJAX_NEW_BATCH ='newBatch';
const AJAX_CHANGE_BATCH = 'changeBatch';

const AJAX_NEW_VENDING = 'newVending';

const AJAX_SHOW_VENDING = 'vendingId';
const AJAX_GENERATE_CUSTOMER_VENDING = 'generateCustomerVending';
const AJAX_SHOW_BATCH_FOR_VENDING = 'getBatch';
const AJAX_ADD_STOCK_TO_VENDING = 'addStockToVending';


const PAGE_VENDING = 'vending';



const ROUTING = [
    PAGE_REGISTER       => '\DaBuild\Controller\CompanyController::register',

    PAGE_HOME           => '\DaBuild\Controller\DefaultController::home',

    PAGE_USERS          => '\DaBuild\Controller\DefaultController::showUsers',
    PAGE_CUSTOMERS      => '\DaBuild\Controller\DefaultController::showCustomers',
    PAGE_VENDINGS       => '\DaBuild\Controller\DefaultController::showVending',

    PAGE_VENDING        => '\DaBuild\Controller\VendingController::buildVending',

    PAGE_STOCK          => '\DaBuild\Controller\BatchController::getStockInfo',

    PAGE_LOGIN          => '\DaBuild\Controller\UserController::login',
    PAGE_LOGOUT         => '\DaBuild\Controller\UserController::logout',

//    PAGE_ADD_VENDING    => '\DaBuild\Controller\DefaultController::vending',

    PAGE_ACCOUNT        =>  '\DaBuild\Controller\DefaultController::pageAccount'
];
