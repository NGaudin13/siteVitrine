<?php

require_once('./config/configuration.php');
require_once('./lib/foncBase.php');
require_once(PATH_TEXTES.LANG.'.php');

$page = $_GET['page'] ?? 'accueil';
$page = preg_replace('/[^a-zA-Z0-9_]/', '', $page);

/**
 * Pages publiques
 */
$publicPages = [
    'accueil',
    'presentation',
    'service',
    'references',
    'contact',
    'appelWhatzapp',
    'conditions',
    'confidentialite'
];

/**
 * Pages admin
 */
$adminPages = [
    'admin',
    'admin_login',
    'admin_dashboard',
    'admin_edit'
];

/**
 * Choix du contrôleur
 */
if (in_array($page, $publicPages, true)) {

    $controllerFile = PATH_CONTROLLERS . 'homeController.php';

} elseif (in_array($page, $adminPages, true)) {

    $controllerFile = PATH_CONTROLLERS . 'adminController.php';

} elseif ($page === 'login' || $page === 'logout') {

    $controllerFile = PATH_CONTROLLERS . 'authController.php';

} else {

    $controllerFile = PATH_CONTROLLERS . '404.php';

}

require_once($controllerFile);
