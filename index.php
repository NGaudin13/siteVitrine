<?php

require_once('./config/configuration.php');     // contient $pdo + PATH_*
require_once('./lib/foncBase.php');
require_once(PATH_TEXTES . LANG . '.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* ============================================================
   1) PAGE (sanitization)
   ============================================================ */
$page = $_GET['page'] ?? 'accueil';
$page = preg_replace('/[^a-zA-Z0-9_]/', '', $page);

/* ============================================================
   2) ROUTES (listes)
   ============================================================ */
$publicPages = [
    'accueil',
    'presentation',
    'service',
    'references',
    'contact',
    'conditions',
    'confidentialite'
];

$adminPages = [
    'adminDashboard',
    'adminAccueil',
    'adminPresentation',
    'adminServices',
    'adminContact',
];

/* ============================================================
   3) GLOBALS SITE (chargés UNE seule fois)
   - dispo dans tous les contrôleurs + vues incluses après
   ============================================================ */
require_once PATH_MODELS . 'UserModel.php';

$userModel = new UserModel($pdo);

/**
 * Hypothèse : la "config globale site" = user id 1
 * (si tu changes d’approche plus tard : table settings, etc.)
 */
$siteUser = $userModel->find(1);

/* ============================================================
   4) CHOIX DU CONTRÔLEUR
   ============================================================ */
if (in_array($page, $publicPages, true)) {
    $controllerFile = PATH_CONTROLLERS . 'homeController.php';
} elseif (in_array($page, $adminPages, true)) {
    $controllerFile = PATH_CONTROLLERS . 'adminController.php';
} elseif ($page === 'login' || $page === 'logout') {
    $controllerFile = PATH_CONTROLLERS . 'authController.php';
} else {
    $controllerFile = PATH_CONTROLLERS . '404.php';
}

/* ============================================================
   5) EXEC CONTROLLER
   ============================================================ */
require_once $controllerFile;
