<?php
// ================= SEO admin =================
$pageTitle = $pageTitle ?? "Admin | OFLABIM";
$metaDesc  = $metaDesc  ?? "Espace d'administration OFLABIM";
$canonical = $canonical ?? "http://localhost/siteVitrine/index.php?page=adminDashboard";

?>

<div class="border rounded-3 p-4 bg-white">

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

        <!-- Horaires -->
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

        <!-- Délais -->
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

</section>


