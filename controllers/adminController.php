<?php
// =========================================================
// FICHIER : siteVitrine/controllers/adminController.php
// Point d'entrée du back-office : accès, CSRF, routage, layout.
// =========================================================

// Variables fournies par index.php (qui inclut ce fichier).
/** @var PDO $pdo */
/** @var string $page */
/** @var User|null $siteUser */

// 🔒 Accès réservé : si pas connecté -> page de connexion
if (empty($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

// Pas de cache navigateur sur l'admin (évite de revoir l'admin après déconnexion)
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

// L'admin ne doit pas apparaître dans Google
header('X-Robots-Tag: noindex, nofollow');

$view      = 'adminDashboard.php';
$activeTab = 'dashboard';
$alert     = null;
$pageTitle = 'Administration | OFLABIM';

// 🔒 CSRF : tout envoi de formulaire admin doit porter le bon jeton.
// Sinon on refuse AVANT d'exécuter le moindre traitement.
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && !csrf_verify()) {
    http_response_code(403);
    $activeTab = '';

    require_once PATH_VIEWS . 'header.php';
    require_once PATH_VIEWS_ADMIN . 'adminTabs.php';
    require_once PATH_VIEWS_ADMIN . 'adminCsrf.php';
    echo "    </div>\n</section>\n";   // ferme le container + la section ouverts par adminTabs.php
    require_once PATH_VIEWS . 'footer.php';
    exit;
}

switch ($page) {

    case 'adminAccueil':
        require_once PATH_CONTROLLERS . 'adminAccueilController.php';
        $controller = new AdminAccueilController($pdo);

        $data = $controller->index();
        if (is_array($data)) {
            extract($data, EXTR_SKIP);
        }

        $view      = 'adminAccueil.php';
        $activeTab = 'accueil';
        break;

    case 'adminDashboard':
        require_once PATH_CONTROLLERS . 'adminDashboardController.php';
        $controller = new AdminDashboardController($pdo);

        $data = $controller->index();
        if (is_array($data)) {
            extract($data, EXTR_SKIP);
        }

        // Le header / footer utilisent $siteUser :
        // en adminDashboard on affiche les valeurs tout juste enregistrées.
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
        require_once PATH_CONTROLLERS . 'adminContactController.php';
        $controller = new AdminContactController($pdo);

        $data = $controller->index();
        if (is_array($data)) {
            extract($data, EXTR_SKIP);
        }

        $view      = 'adminContact.php';
        $activeTab = 'contact';
        break;

    default:
        // Page admin inconnue => 404
        http_response_code(404);
        $alert     = choixAlert('url_non_valide');
        $view      = 'admin404.php';
        $activeTab = '';
        break;
}

// Layout ADMIN (UNE SEULE FOIS)
require_once PATH_VIEWS . 'header.php';
require_once PATH_VIEWS_ADMIN . 'adminTabs.php';
require_once PATH_VIEWS_ADMIN . $view;
echo "    </div>\n</section>\n";   // ferme le container + la section ouverts par adminTabs.php
require_once PATH_VIEWS . 'footer.php';