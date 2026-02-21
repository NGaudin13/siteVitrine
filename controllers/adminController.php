<?php
// controllers/adminController.php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// 🔒 Protection: si pas connecté -> redirection login
if (empty($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

// (optionnel mais conseillé) éviter le cache après logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

$page = $_GET['page'] ?? 'adminDashboard';
$page = preg_replace('/[^a-zA-Z0-9_]/', '', $page);

$view      = 'adminDashboard.php';
$activeTab = 'dashboard';
$alert     = null;

switch ($page) {

    case 'adminAccueil':
        require_once PATH_CONTROLLERS . 'AdminAccueilController.php';
        $controller = new AdminAccueilController($pdo);

        $data = $controller->index();
        if (is_array($data)) {
            extract($data, EXTR_SKIP);
        }

        $view      = 'adminAccueil.php';
        $activeTab = 'accueil';
        break;

    case 'adminDashboard':
        require_once PATH_CONTROLLERS . 'AdminDashboardController.php';
        $controller = new AdminDashboardController($pdo);

        $data = $controller->index();
        if (is_array($data)) {
            extract($data, EXTR_SKIP);
        }

        // ✅ IMPORTANT : le header / footer utilisent $siteUser
        // Donc en adminDashboard, on force $siteUser = $admin (valeurs à jour)
        if (isset($admin)) {
            $siteUser = $admin;
        }

        $view      = 'adminDashboard.php';
        $activeTab = 'dashboard';
        break;

    case 'adminPresentation':
        require_once PATH_CONTROLLERS . 'AdminPresentationController.php';
        $controller = new AdminPresentationController($pdo);

        $data = $controller->index();
        if (is_array($data)) {
            extract($data, EXTR_SKIP);
        }

        $view      = 'adminPresentation.php';
        $activeTab = 'presentation';
        break;

     case 'adminContact':
        require_once PATH_CONTROLLERS . 'AdminContactController.php';
        $controller = new AdminContactController($pdo);

        $data = $controller->index();
        if (is_array($data)) {
            extract($data, EXTR_SKIP);
        }

        $view      = 'adminContact.php';
        $activeTab = 'contact';
        break;

    default:
        // ✅ Admin : page inconnue => 404
        http_response_code(404);
        $alert = choixAlert('url_non_valide');

        // Vue 404 admin dédiée
        $view      = 'admin404.php';
        $activeTab = ''; // aucune tab active
        break;
}

// Layout ADMIN (UNE SEULE FOIS)
require_once PATH_VIEWS . 'header.php';
require_once PATH_VIEWS_ADMIN . 'adminTabs.php';
require_once PATH_VIEWS_ADMIN . $view;
require_once PATH_VIEWS . 'footer.php';
