<?php
// SEO admin (optionnel)
$pageTitle = $pageTitle ?? "Admin | OFLABIM";
$metaDesc  = $metaDesc  ?? "Espace d'administration OFLABIM";
$canonical = $canonical ?? "http://localhost/siteVitrine/index.php?page=adminDashboard";

require_once(PATH_VIEWS . 'header.php');
?>

<section class="admin-shell py-4">
    <div class="container">

        <div class="admin-header d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
            <div>
                <h1 class="h3 mb-1">Administration</h1>
                <p class="text-muted mb-0">Gérez les contenus du site (version simple).</p>
            </div>

            <a href="index.php?page=accueil" class="btn btn-outline-dark btn-sm">
                Retour au site
            </a>
        </div>

        <!-- Onglets admin -->
        <ul class="nav nav-pills gap-2" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" href="index.php?page=adminDashboard">
                    Admin général
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="index.php?page=adminAccueil">
                    Admin accueil
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="index.php?page=adminPresentation">
                    Admin presentation
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="index.php?page=adminServices">
                    Admin services
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="index.php?page=adminContact">
                    Admin contact
                </a>
            </li>
        </ul>

        <div class="border rounded-3 p-4 mt-3 bg-white">

            <h2 class="h5 mb-3">Paramètres généraux de l’entreprise</h2>

            <p class="text-muted mb-4">
                Ces informations sont utilisées dans le site (header, footer, page contact).
                Les modifications sont appliquées immédiatement.
            </p>

            <?php if (!empty($flashSuccess)): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($flashSuccess) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="index.php?page=adminDashboard" class="row g-3">

                <!-- Nom entreprise -->
                <div class="col-md-6">
                    <label class="form-label">Nom de l’entreprise</label>
                    <input
                        type="text"
                        name="company_name"
                        class="form-control"
                        required
                        value="<?= htmlspecialchars($admin->getCompanyName() ?? '') ?>"
                    >
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label class="form-label">Email de contact</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        required
                        value="<?= htmlspecialchars($admin->getEmail() ?? '') ?>"
                    >
                </div>

                <!-- Téléphone -->
                <div class="col-md-6">
                    <label class="form-label">Téléphone</label>
                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        required
                        value="<?= htmlspecialchars($admin->getPhone() ?? '') ?>"
                    >
                </div>

                <!-- Adresse -->
                <div class="col-12">
                    <label class="form-label">Adresse</label>
                    <textarea
                        name="address"
                        required
                        class="form-control"
                        rows="2"
                    ><?= htmlspecialchars($admin->getAddress() ?? '') ?></textarea>
                </div>
                
                <!-- Horraire -->
                <div class="col-md-6">
                    <label class="form-label">Horaires d’ouverture</label>
                    <input
                        type="text"
                        name="opening_hours"
                        class="form-control"
                        required
                        value="<?= htmlspecialchars($admin->getOpeningHours() ?? '') ?>"
                    >
                </div>

                <!-- Delais de reponses -->
                <div class="col-md-6">
                    <label class="form-label">Délai de réponse</label>
                    <input
                        type="text"
                        name="response_delay"
                        class="form-control"
                        required
                        value="<?= htmlspecialchars($admin->getResponseDelay() ?? '') ?>"
                    >
                </div>

                <!-- Submit -->
                <div class="col-12 pt-2">
                    <button class="btn btn-primary">
                        Enregistrer les modifications
                    </button>
                </div>

            </form>

        </div>
    </div>
</section>

<?php require_once(PATH_VIEWS . 'footer.php'); ?>
