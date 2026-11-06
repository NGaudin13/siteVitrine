<?php
// =========================================================
// FICHIER : siteVitrine/controllers/authController.php
// Connexion / déconnexion du back-office.
// =========================================================

// Variables fournies par index.php (qui inclut ce fichier).
// Ces annotations les déclarent à VS Code / Intelephense,
// qui analyse ce fichier seul et ne voit pas index.php.
/** @var PDO $pdo */
/** @var string $page */

require_once PATH_MODELS . 'UserModel.php';

$userModel = new UserModel($pdo);

$view      = 'login.php';
$error     = null;
$pageTitle = 'Connexion | OFLABIM';
$metaDesc  = 'Accès réservé à l’administration du site.';
$canonical = url_page('login');

/* ================= LOGIN ================= */

if ($page === 'login') {

    // Déjà connecté : inutile de réafficher le formulaire
    if (!empty($_SESSION['user_id'])) {
        header('Location: index.php?page=adminDashboard');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !csrf_verify()) {

        // Jeton CSRF absent ou faux : on n'essaie même pas la connexion
        http_response_code(403);
        $error = "Formulaire expiré, merci de réessayer.";

    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user->getPasswordHash())) {

            // SÉCURITÉ : nouvel identifiant de session à chaque connexion.
            // Empêche la "fixation de session" (un attaquant qui aurait
            // imposé un identifiant à la victime avant qu'elle se connecte).
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user->getId();
            $_SESSION['role']    = 'admin';

            header('Location: index.php?page=adminDashboard');
            exit;
        }

        // Message volontairement vague : on ne dit pas si c'est
        // l'email ou le mot de passe qui est faux.
        $error = "Identifiants invalides";
    }
}

/* ================= LOGOUT ================= */

if ($page === 'logout') {

    // 1) Vider les données de session
    $_SESSION = [];

    // 2) Supprimer le cookie de session dans le navigateur
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    // 3) Détruire la session côté serveur
    session_destroy();

    header('Location: index.php?page=accueil');
    exit;
}

/* ================= LAYOUT ================= */

require PATH_VIEWS . 'header.php';
require PATH_VIEWS . $view;
require PATH_VIEWS . 'footer.php';