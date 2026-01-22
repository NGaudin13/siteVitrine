<?php

$page = $_GET['page'] ?? 'accueil';

switch ($page) {

    case 'accueil':
        require_once(PATH_VIEWS . 'accueil.php');
        break;

    case 'presentation':
        require_once(PATH_VIEWS . 'presentation.php');
        break;

    case 'service':
        require_once(PATH_VIEWS . 'service.php');
        break;

    case 'contact':
        require_once(PATH_CONTROLLERS . 'contactController.php');
        break;

    case 'conditions':
        require_once(PATH_VIEWS . 'conditions.php');
        break;

    case 'confidentialite':
        require_once(PATH_VIEWS . 'confidentialite.php');
        break;

    default:
        require_once(PATH_VIEWS . '404.php');
        break;

}
