<?php

require_once PATH_MODELS . 'PageModel.php';
require_once PATH_MODELS . 'SectionModel.php';
require_once PATH_MODELS . 'ContentBlockModel.php';

/**
 * IMPORTANT :
 * - $pdo est dispo via configuration.php (index.php l'a déjà chargé)
 * - $siteUser est déjà chargé dans index.php (global site config)
 */

$page = $_GET['page'] ?? 'accueil';
$page = preg_replace('/[^a-zA-Z0-9_]/', '', $page);

/* ======================================================
   1) CONTENU DYNAMIQUE DES PAGES
   ====================================================== */

$pageModel         = new PageModel($pdo);
$sectionModel      = new SectionModel($pdo);
$contentBlockModel = new ContentBlockModel($pdo);

$sectionsContent = [];
$pageEntity = $pageModel->findBySlug($page);

if ($pageEntity) {
    $sections = $sectionModel->findByPageId(
        (int) $pageEntity->getId(),
        true
    );

    foreach ($sections as $section) {
        $blocks = $contentBlockModel->findBySectionIdIndexedBySlot(
            (int) $section->getId(),
            true
        );

        foreach ($blocks as $slot => $block) {
            if ($block->getType() === 'img') {
                $sectionsContent[$section->getSlug()][$slot] = [
                    'src' => $block->getSrc(),
                    'alt' => $block->getAlt(),
                ];
            } else {
                $sectionsContent[$section->getSlug()][$slot] = $block->getText();
            }
        }
    }
}

/* ======================================================
   2) CHOIX DE LA VUE (PAS D'AFFICHAGE ICI)
   ====================================================== */

$view  = '404.php';
$alert = null;

switch ($page) {
    case 'accueil':
        $view = 'accueil.php';
        break;

    case 'presentation':
        $view = 'presentation.php';
        break;

    case 'service':
        $view = 'service.php';
        break;

    case 'conditions':
        $view = 'conditions.php';
        break;

    case 'confidentialite':
        $view = 'confidentialite.php';
        break;

    case 'contact':
        require PATH_CONTROLLERS . 'contactController.php';
        $view = 'contact.php';
    break;

    default:
        http_response_code(404);
        $alert = choixAlert('url_non_valide');
        $view  = '404.php';
        break;

}

/* ======================================================
   3) LAYOUT UNIQUE (HEADER + VUE + FOOTER)
   ====================================================== */

require PATH_VIEWS . 'header.php';
require PATH_VIEWS . $view;
require PATH_VIEWS . 'footer.php';
