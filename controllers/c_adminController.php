<?php

switch ($page) {

    case 'admin_dashboard':
    default:
        require_once PATH_CONTROLLERS . 'AdminDashboardController.php';
        $controller = new AdminDashboardController($pdo);
        $controller->index();
        break;
}
