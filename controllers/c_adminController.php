<?php

switch ($page) {

    case 'adminAccueil':
        require_once PATH_CONTROLLERS . 'AdminAccueilController.php';
        $controller = new AdminAccueilController($pdo);
        $controller->index();
        break;

    case 'adminDashboard':
    default:
        require_once PATH_CONTROLLERS . 'AdminDashboardController.php';
        $controller = new AdminDashboardController($pdo);
        $controller->index();
        break;
}
