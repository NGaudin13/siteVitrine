<?php

$page = $_GET['page'] ?? 'accueil';

switch ($page) {

    case 'accueil':
        require_once(PATH_VIEWS . 'accueil.php');
        break;

    case 'presentation':
        require_once(PATH_VIEWS . 'presentation.php');
        break;

    case 'expertise':
        require_once(PATH_VIEWS . 'expertise.php');
        break;

    case 'contact':
        require_once(PATH_VIEWS . 'contact.php');
        break;

    case 'conditions':
        require_once(PATH_VIEWS . 'conditions.php');
        break;

    case 'confidentialite':
        require_once(PATH_VIEWS . 'confidentialite.php');
        break;
    
    case 'references':
        require_once(PATH_VIEWS . 'references.php');
        break;

    default:
        require_once(PATH_VIEWS . '404.php');
        break;

}
