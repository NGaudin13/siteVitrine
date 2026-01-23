<section class="container py-5">
    <div class="text-center mx-auto" style="max-width: 720px;">

        <h1 class="display-6 fw-bold mb-2">Page introuvable</h1>

        <p class="text-muted mb-4">
            L’adresse demandée n’existe pas (ou a été déplacée).
        </p>

        <?php if (!empty($alert)): ?>
            <div class="alert alert-warning">
                <?= $alert ?>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-center gap-2 flex-wrap">
            <a href="index.php?page=accueil" class="btn btn-primary">
                Retour à l’accueil
            </a>

            <a href="javascript:history.back()" class="btn btn-outline-dark">
                Revenir en arrière
            </a>
        </div>

    </div>
</section>
