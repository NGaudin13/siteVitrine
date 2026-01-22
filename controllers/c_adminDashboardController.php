<?php

require_once PATH_ENTITY . 'User.php';
require_once PATH_MODELS   . 'UserModel.php';

class AdminDashboardController
{
    private UserModel $userModel;

    public function __construct(PDO $pdo)
    {
        $this->userModel = new UserModel($pdo);
    }

    /**
     * Dashboard admin – paramètres généraux du site
     */
    public function index(): void
    {
        // ⚠️ MVP : admin hardcodé
        // plus tard => $_SESSION['user_id']
        $adminId = 1;

        $errors = [];
        $flashSuccess = null;

        // =========================
        // 1. Charger l'admin
        // =========================
        $admin = $this->userModel->find($adminId);

        if (!$admin) {
            http_response_code(404);
            echo 'Utilisateur admin introuvable';
            return;
        }

        // =========================
        // 2. Traitement POST
        // =========================
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Hydratation via setters (Symfony-like)
            $admin
                ->setUsername(trim($_POST['company_name'] ?? ''))
                ->setCompanyName($_POST['company_name'] ?? '')
                ->setEmail(trim($_POST['email'] ?? ''))
                ->setPhone(trim($_POST['phone'] ?? null))
                ->setAddress(trim($_POST['address'] ?? null));

            // =========================
            // 3. Validation minimale
            // =========================
            if ($admin->getCompanyName() === '') {
                $errors['company_name'] = "Le nom de l’entreprise est obligatoire.";
            }

            if (mb_strlen($admin->getCompanyName()) > 150) {
                $errors['company_name'] = "Nom trop long (150 caractères max).";
            }

            if (
                $admin->getEmail() === '' ||
                !filter_var($admin->getEmail(), FILTER_VALIDATE_EMAIL)
            ) {
                $errors['email'] = 'Adresse email invalide.';
            }

            // =========================
            // 4. Sauvegarde
            // =========================
            if (empty($errors)) {
                $this->userModel->save($admin);
                $flashSuccess = 'Modifications enregistrées avec succès.';
            }
        }

        // =========================
        // 5. Render vue
        // =========================
        require PATH_VIEWS_ADMIN . 'dashboard.php';
    }
}
