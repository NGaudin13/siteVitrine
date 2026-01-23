<section class="container py-5">
    <div class="text-center mx-auto" style="max-width: 720px;">

        <h1 class="display-6 fw-bold mb-2">Page admin introuvable</h1>

        <p class="text-muted mb-4">
            La page d’administration demandée n’existe pas ou n’est plus disponible.
        </p>

        <?php if (!empty($alert)): ?>
            <div class="alert alert-warning">
                <?= htmlspecialchars($alert, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-center gap-2 flex-wrap">
            <a href="index.php?page=adminDashboard" class="btn btn-primary">
                Retour au dashboard
            </a>

            <a href="index.php?page=accueil" class="btn btn-outline-dark">
                Retour au site
            </a>
        </div>

    </div>
</section>
