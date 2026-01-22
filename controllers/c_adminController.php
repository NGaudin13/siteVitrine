<?php

switch ($page) {

    case 'admin_dashboard':
    default:
        require_once PATH_CONTROLLERS . 'AdminDashboardController.php';
        $controller = new AdminDashboardController($pdo);
        $controller->index();
        break;

    case 'admin_accueil':
        require_once PATH_CONTROLLERS . 'AdminAccueilController.php';
        $controller = new AdminAccueilController($pdo);
        $controller->index();
        break;

    case 'admin_presentation':
        require_once PATH_CONTROLLERS . 'AdminPresentationController.php';
        $controller = new AdminPresentationController($pdo);
        $controller->index();
        break;

    case 'admin_services':
        require_once PATH_CONTROLLERS . 'AdminServicesController.php';
        $controller = new AdminServicesController($pdo);
        $controller->index();
        break;

    case 'admin_contact':
        require_once PATH_CONTROLLERS . 'AdminContactController.php';
        $controller = new AdminContactController($pdo);
        $controller->index();
        break;
}
