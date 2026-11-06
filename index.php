<?php
// =========================================================
// FICHIER : siteVitrine/index.php
// =========================================================

require_once('./config/configuration.php');     // contient $pdo + PATH_*
require_once('./lib/foncBase.php');
require_once(PATH_TEXTES . LANG . '.php');

// Erreurs : affichées en local (DEBUG), jamais aux visiteurs en ligne
// (elles restent enregistrées dans le journal d'erreurs du serveur).
error_reporting(E_ALL);
ini_set('display_errors', DEBUG ? '1' : '0');
ini_set('display_startup_errors', DEBUG ? '1' : '0');
ini_set('log_errors', '1');

// Cookie de session sécurisé (à régler AVANT session_start) :
// - use_strict_mode : refuse un identifiant de session inventé par un attaquant
// - cookie_httponly : le cookie n'est pas lisible en JavaScript (vol par XSS)
// - cookie_samesite : le cookie n'est pas envoyé depuis un autre site (CSRF)
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');
// En HTTPS : le cookie de session ne circule jamais en clair
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
    ini_set('session.cookie_secure', '1');
}

// Session démarrée UNE SEULE FOIS pour tout le site.
// Les contrôleurs ne doivent PAS rappeler session_start().
session_start();

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
    'confidentialite',
    'mentions',
    'login',
];

// 'adminServices' retiré : aucun contrôleur ni vue n'existe encore.
// À remettre quand la page Admin services sera construite.
$adminPages = [
    'adminDashboard',
    'adminAccueil',
    'adminPresentation',
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
if ($page === 'login' || $page === 'logout') {

    $controllerFile = PATH_CONTROLLERS . 'authController.php';

} elseif (in_array($page, $adminPages, true)) {

    $controllerFile = PATH_CONTROLLERS . 'adminController.php';

} elseif (in_array($page, $publicPages, true)) {

    $controllerFile = PATH_CONTROLLERS . 'homeController.php';

} else {

    $controllerFile = PATH_CONTROLLERS . '404.php';
}

/* ============================================================
   5) EXEC CONTROLLER
   ============================================================ */
require_once $controllerFile;