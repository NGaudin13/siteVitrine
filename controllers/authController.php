<?php

require_once PATH_MODELS . 'UserModel.php';

$userModel = new UserModel($pdo);

$view = 'login.php';
$error = null;

/* ================= LOGIN ================= */

if ($page === 'login') {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user->getPasswordHash())) {

            $_SESSION['user_id'] = $user->getId();
            $_SESSION['role']    = 'admin';

            header('Location: index.php?page=adminDashboard');
            exit;
        }

        $error = "Identifiants invalides";
    }

}

/* ================= LOGOUT ================= */

if ($page === 'logout') {
    session_destroy();
    header('Location: index.php?page=accueil');
    exit;
}

/* ================= LAYOUT ================= */

require PATH_VIEWS . 'header.php';
require PATH_VIEWS . $view;
require PATH_VIEWS . 'footer.php';