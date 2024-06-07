<?php
//Load twig
require 'includes/autoload.php';

//Get current file name
$uri = $_SERVER['REQUEST_URI'];
//Remove query string from URI
$urlNoQuery = parse_url($uri, PHP_URL_PATH);
//Get file name without extension
$activePage = basename($urlNoQuery, '.php');

include 'includes/user_functions.php';

//Create an array with all pages
$pages = [
    'index'      => [
        'url'           => 'index.php',
        'isActive'      =>  $activePage == 'index'
    ],
    'products'      => [
        'url'           => 'products.php',
        'isActive'      =>  $activePage == 'products'
    ],
    'product'      => [
        'url'           => 'product.php',
        'isActive'      =>  $activePage == 'product'
    ],
    'contact'      => [
        'url'           => 'contact.php',
        'isActive'      =>  $activePage == 'contact'
    ],
    'login'      => [
        'url'           => 'login.php',
        'isActive'      =>  $activePage == 'login'
    ],
    'register'      => [
        'url'           => 'register.php',
        'isActive'      =>  $activePage == 'register'
    ],
    'cart'      => [
        'url'           => 'cart.php',
        'isActive'      =>  $activePage == 'cart'
    ],
    'orders'    => [
        'url'           => 'orders.php',
        'isActive'      => $activePage == 'orders'
    ]
];

if (isset($_SESSION['user_id'])) {
    $user_id            = $_SESSION['user_id'];
    $basket_quantity    = getMyItems($user_id);
    $total_orders       = getMyOrders($user_id);
    } else {
    $basket_quantity    = 0;
    $total_orders       = 0;
}

//User data if logged and which email Address
$user_data = [
    'user_logged_in'    => isset($_SESSION['loggedin']) && $_SESSION['loggedin'],
    'email'             => isset($_SESSION['email']) ? $_SESSION['email'] : null,
    'first_name'        => isset($_SESSION['first_name']) ? $_SESSION['first_name'] : null,
    'last_name'         => isset($_SESSION['last_name']) ? $_SESSION['last_name'] : null,
    'user_id'           => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null,
    'basket_quantity'   => $basket_quantity,
    'total_orders'      => $total_orders,
];

//Return what we have

return [
    'pages'             => $pages,
    'activePage'        => $activePage,
    'user'              => $user_data
];

