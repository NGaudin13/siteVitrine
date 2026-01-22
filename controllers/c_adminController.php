<?php

switch ($page) {

    case 'admin_dashboard':
        require_once(PATH_VIEWS_ADMIN . 'dashboard.php');
        break;

    case 'admin_accueil':
        require_once(PATH_VIEWS_ADMIN . 'accueil.php');
        break;
    
    case 'admin_presentation':
        require_once(PATH_VIEWS_ADMIN . 'presentation.php');
        break;

    case 'admin_services':
        require_once(PATH_VIEWS_ADMIN . 'services.php');
        break;

    case 'admin_contact':
        require_once(PATH_VIEWS_ADMIN . 'contact.php');
        break;

    default:
        require_once(PATH_VIEWS_ADMIN . 'dashboard.php');
        break;
}
