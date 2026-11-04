<?php
// =========================================================
// FICHIER : siteVitrine/controllers/homeController.php
// Pages publiques : contenu dynamique, SEO, choix de la vue.
// =========================================================

// Variables fournies par index.php (qui inclut ce fichier).
/** @var PDO $pdo */
/** @var string $page */
/** @var User|null $siteUser */

require_once PATH_MODELS . 'PageModel.php';
require_once PATH_MODELS . 'SectionModel.php';
require_once PATH_MODELS . 'ContentBlockModel.php';

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
   2) SEO : titre + description de CHAQUE page
   ------------------------------------------------------
   Doit être prêt AVANT d'inclure header.php, qui les affiche.
   Priorité : table `page` (modifiable en base), sinon valeurs ci-dessous.
   ====================================================== */

$seoParDefaut = [
    'conditions' => [
        'Conditions générales d’utilisation | OFLABIM',
        'Conditions générales d’utilisation du site OFLABIM, bureau d’études & ingénierie BIM.',
    ],
    'confidentialite' => [
        'Politique de confidentialité | OFLABIM',
        'Comment OFLABIM collecte et protège vos données personnelles.',
    ],
    'mentions' => [
        'Mentions légales | OFLABIM',
        'Mentions légales du site OFLABIM : éditeur, hébergeur, propriété intellectuelle.',
    ],
];

$pageTitle = "OFLABIM | Bureau d'Études & Ingénierie BIM";
$metaDesc  = "Bureau d'études et ingénierie – solutions techniques, BIM et accompagnement de projets.";

if ($pageEntity) {
    $pageTitle = $pageEntity->getMetaTitle() ?: ($pageEntity->getTitle() . ' | OFLABIM');
    $metaDesc  = $pageEntity->getMetaDesc() ?: $metaDesc;
} elseif (isset($seoParDefaut[$page])) {
    [$pageTitle, $metaDesc] = $seoParDefaut[$page];
}

// Calculée depuis l'adresse réelle : fonctionne en local ET en ligne
$canonical = url_page($page);

/* ======================================================
   3) CHOIX DE LA VUE (PAS D'AFFICHAGE ICI)
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

    case 'mentions':
        $view = 'mentions.php';
        break;

    case 'contact':
        require PATH_CONTROLLERS . 'contactController.php';
        $view = 'contact.php';
        break;

    default:
        http_response_code(404);
        $alert     = choixAlert('url_non_valide');
        $view      = '404.php';
        $pageTitle = 'Page introuvable | OFLABIM';
        break;
}

/* ======================================================
   4) LAYOUT UNIQUE (HEADER + VUE + FOOTER)
   ====================================================== */

require PATH_VIEWS . 'header.php';
require PATH_VIEWS . $view;
require PATH_VIEWS . 'footer.php';