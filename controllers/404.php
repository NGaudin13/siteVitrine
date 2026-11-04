<?php
// =========================================================
// FICHIER : siteVitrine/controllers/404.php
// =========================================================

http_response_code(404);

$alert = choixAlert('url_non_valide');
$view  = '404.php';

// Layout identique aux autres pages
require PATH_VIEWS . 'header.php';
require PATH_VIEWS . $view;
require PATH_VIEWS . 'footer.php';