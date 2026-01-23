<?php
// ===================== VUE : views/views_admin/adminAccueil.php =====================

// SEO admin (optionnel)
$pageTitle = $pageTitle ?? "Admin Accueil | OFLABIM";
$metaDesc  = $metaDesc  ?? "Administration de la page Accueil";
$canonical = $canonical ?? "http://localhost/siteVitrine/index.php?page=adminAccueil";

// Onglet actif
$activeTab = 'accueil';

require_once(PATH_VIEWS . 'header.php');
require_once(PATH_VIEWS_ADMIN . 'adminTabs.php');
?>

<div class="border rounded-3 p-4 bg-white">

    <?php
    // ===== Bloc flash simple =====
    if (!empty($flashSuccess)) {
        echo '<div class="alert alert-success">' . htmlspecialchars($flashSuccess) . '</div>';
    }
    if (!empty($flashError)) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($flashError) . '</div>';
    }
    ?>

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h2 class="h5 mb-1">Accueil — Administration</h2>
            <p class="text-muted mb-0">
                Choisissez une section de la page Accueil à modifier.
            </p>
        </div>
    </div>

    <!-- ================= CHOIX SECTION ================= -->
    <div class="row g-3 align-items-end mb-4">
        <div class="col-md-8">
            <label class="form-label">Section à modifier</label>

            <select
                class="form-select"
                onchange="window.location.href='index.php?page=adminAccueil&section=' + encodeURIComponent(this.value)"
            >
                <?php foreach ($sections as $s): ?>
                    <option
                        value="<?= htmlspecialchars($s->getSlug()) ?>"
                        <?= ($selectedSlug ?? '') === $s->getSlug() ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($s->getAdminTitle()) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <div class="form-text">
                Pour l’instant, seul <code>Accueil - Le BIM</code> est éditable.
            </div>
        </div>

        <div class="col-md-4 text-md-end">
            <a class="btn btn-outline-dark"
               href="index.php?page=accueil"
               target="_blank">
                Voir la page Accueil
            </a>
        </div>
    </div>

    <hr class="my-4">

    <?php if (($selectedSlug ?? '') === 'home-bim'): ?>

        <div class="mb-3">
            <h3 class="h6 mb-1">Section “Le BIM”</h3>
            <p class="text-muted mb-0">
                Aperçu du contenu actuel, puis édition juste en dessous.
            </p>
        </div>

        <!-- ================= APERÇU (EN HAUT) ================= -->
        <div class="p-3 rounded-3 bg-light border mb-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-7">
                    <div class="h5 mb-2">
                        <?= htmlspecialchars($blockTitle?->getText() ?? '') ?>
                    </div>

                    <p class="text-muted mb-2">
                        <?= nl2br(htmlspecialchars($blockP1?->getText() ?? '')) ?>
                    </p>

                    <p class="text-muted mb-0">
                        <?= nl2br(htmlspecialchars($blockP2?->getText() ?? '')) ?>
                    </p>
                </div>

                <div class="col-md-5">
                    <?php if (!empty($blockImg?->getSrc())): ?>
                        <img
                            src="<?= htmlspecialchars($blockImg->getSrc()) ?>"
                            alt="<?= htmlspecialchars($blockImg?->getAlt() ?? '') ?>"
                            class="img-fluid rounded-3"
                            loading="lazy"
                        >
                    <?php else: ?>
                        <div class="text-muted small">
                            Aucune image renseignée.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- ================= FORMULAIRE ================= -->
        <form method="post"
              enctype="multipart/form-data"
              action="index.php?page=adminAccueil&section=<?= urlencode($selectedSlug) ?>"
              class="row g-3">

            <input type="hidden" name="section_slug" value="<?= htmlspecialchars($selectedSlug) ?>">

            <!-- TITRE -->
            <div class="col-12">
                <label class="form-label">Titre (H2)</label>
                <input
                    type="text"
                    class="form-control"
                    name="title"
                    value="<?= htmlspecialchars($blockTitle?->getText() ?? '') ?>"
                    required
                >
            </div>

            <!-- P1 -->
            <div class="col-12">
                <label class="form-label">Paragraphe 1</label>
                <textarea class="form-control" name="text_1" rows="4" required><?= htmlspecialchars($blockP1?->getText() ?? '') ?></textarea>
            </div>

            <!-- P2 -->
            <div class="col-12">
                <label class="form-label">Paragraphe 2</label>
                <textarea class="form-control" name="text_2" rows="6" required><?= htmlspecialchars($blockP2?->getText() ?? '') ?></textarea>
            </div>

            <!-- IMAGE SRC (lecture seule) -->
            <div class="col-md-7">
                <label class="form-label">Image (src)</label>

                <!-- affichage bloqué -->
                <input
                    type="text"
                    class="form-control"
                    value="<?= htmlspecialchars($blockImg?->getSrc() ?? '') ?>"
                    readonly
                >

                <!-- valeur réellement envoyée au controller -->
                <input
                    type="hidden"
                    name="image_src"
                    value="<?= htmlspecialchars($blockImg?->getSrc() ?? '') ?>"
                >

                <div class="form-text">
                    Le <code>src</code> est géré automatiquement. Pour le changer, upload une nouvelle image.
                </div>
            </div>

            <!-- ALT -->
            <div class="col-md-5">
                <label class="form-label">Texte alternatif (alt)</label>
                <input
                    type="text"
                    class="form-control"
                    name="image_alt"
                    value="<?= htmlspecialchars($blockImg?->getAlt() ?? '') ?>"
                    required
                >
            </div>

            <!-- UPLOAD -->
            <div class="col-12">
                <label class="form-label">Ou charger une image (remplace le src)</label>
                <input
                    type="file"
                    class="form-control"
                    name="image_file"
                    accept="image/jpeg,image/png,image/webp"
                >
                <div class="form-text">
                    JPG/PNG/WEBP — si tu upload, le <code>src</code> sera remplacé automatiquement.
                </div>
            </div>

            <!-- SUBMIT -->
            <div class="col-12 pt-2">
                <button class="btn btn-primary">
                    Enregistrer la section BIM
                </button>

                <a href="index.php?page=accueil#homeBin"
                   class="btn btn-outline-dark ms-2"
                   target="_blank">
                    Voir côté site
                </a>
            </div>

        </form>

    <?php else: ?>

        <div class="alert alert-info mb-0">
            Cette section n’est pas encore éditable.
        </div>

    <?php endif; ?>

</div>

</section>

<?php require_once(PATH_VIEWS . 'footer.php'); ?>
