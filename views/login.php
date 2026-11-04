<?php
// =========================================================
// FICHIER : siteVitrine/views/login.php
// Formulaire de connexion au back-office.
// =========================================================

// Variables fournies par le contrôleur qui inclut cette vue
// (déclarées ici pour VS Code / Intelephense).
/** @var string|null $error */

?>
<div class="container py-5" style="max-width: 500px;">
    <h1 class="h2 mb-4 text-center">Connexion Admin</h1>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <form method="post" action="index.php?page=login">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label" for="login-email">Email</label>
            <input type="email" id="login-email" name="email" class="form-control"
                   autocomplete="username" required>
        </div>

        <div class="mb-3">
            <label class="form-label" for="login-password">Mot de passe</label>
            <input type="password" id="login-password" name="password" class="form-control"
                   autocomplete="current-password" required>
        </div>

        <button type="submit" class="btn btn-dark w-100">
            Se connecter
        </button>
    </form>
</div>