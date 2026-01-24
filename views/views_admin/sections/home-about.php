<?php
// views_admin/sections/home-about.php

$b = $blocks ?? [];

$title = $b['title']  ?? null;
$text1 = $b['text_1'] ?? null;
$text2 = $b['text_2'] ?? null;
$image = $b['image']  ?? null;

// Stats (valeurs uniquement)
$stat1Value = $b['stat_1_value'] ?? null; // ex: "45+"
$stat2Value = $b['stat_2_value'] ?? null; // ex: "100%"

// Labels non modifiables (en dur)
$stat1Label = "Projets terminés";
$stat2Label = "Clients satisfaits";
?>

<!-- ================= APERÇU ================= -->
<div class="p-3 rounded-3 bg-light border mb-4">
    <div class="row g-3 align-items-center">
        <div class="col-md-7">
            <div class="h5 mb-2">
                <?= htmlspecialchars($title?->getText() ?? '') ?>
            </div>

            <p class="text-muted mb-2">
                <?= nl2br(htmlspecialchars($text1?->getText() ?? '')) ?>
            </p>

            <p class="text-muted mb-3">
                <?= nl2br(htmlspecialchars($text2?->getText() ?? '')) ?>
            </p>

            <!-- STATS PREVIEW -->
            <div class="row g-3">
                <div class="col-6">
                    <div class="p-3 bg-white border rounded-3 h-100">
                        <div class="display-6 fw-bold mb-1">
                            <?= htmlspecialchars($stat1Value?->getText() ?? '') ?>
                        </div>
                        <div class="fw-semibold text-muted">
                            <?= htmlspecialchars($stat1Label) ?>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="p-3 bg-white border rounded-3 h-100">
                        <div class="display-6 fw-bold mb-1">
                            <?= htmlspecialchars($stat2Value?->getText() ?? '') ?>
                        </div>
                        <div class="fw-semibold text-muted">
                            <?= htmlspecialchars($stat2Label) ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-5">
            <?php if (!empty($image?->getSrc())): ?>
                <img
                    src="<?= htmlspecialchars($image->getSrc()) ?>"
                    alt="<?= htmlspecialchars($image?->getAlt() ?? '') ?>"
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

    <div class="col-12">
        <label class="form-label">Titre (H2)</label>
        <input
            type="text"
            class="form-control"
            name="title"
            value="<?= htmlspecialchars($title?->getText() ?? '') ?>"
            required
        >
    </div>

    <div class="col-12">
        <label class="form-label">Paragraphe 1</label>
        <textarea class="form-control" name="text_1" rows="4" required><?= htmlspecialchars($text1?->getText() ?? '') ?></textarea>
    </div>

    <!-- STATS (valeurs uniquement) -->
    <div class="col-md-6">
        <label class="form-label">Nombre de projets terminés</label>
        <input
            type="text"
            class="form-control"
            name="stat_1_value"
            value="<?= htmlspecialchars($stat1Value?->getText() ?? '') ?>"
            placeholder="Ex: 45+"
            required
        >
        <div class="form-text">
            Libellé fixe : <strong><?= htmlspecialchars($stat1Label) ?></strong>
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label">Pourcentage de clients satisfait</label>
        <input
            type="text"
            class="form-control"
            name="stat_2_value"
            value="<?= htmlspecialchars($stat2Value?->getText() ?? '') ?>"
            placeholder="Ex: 100%"
            required
        >
        <div class="form-text">
            Libellé fixe : <strong><?= htmlspecialchars($stat2Label) ?></strong>
        </div>
    </div>

    <div class="col-md-7">
        <label class="form-label">Image (src)</label>

        <input
            type="text"
            class="form-control"
            value="<?= htmlspecialchars($image?->getSrc() ?? '') ?>"
            readonly
        >

        <input
            type="hidden"
            name="image_src"
            value="<?= htmlspecialchars($image?->getSrc() ?? '') ?>"
        >

        <div class="form-text">
            Le <code>src</code> est géré automatiquement. Pour le changer, upload une nouvelle image.
        </div>
    </div>

    <div class="col-md-5">
        <label class="form-label">Texte alternatif (alt)</label>
        <input
            type="text"
            class="form-control"
            name="image_alt"
            value="<?= htmlspecialchars($image?->getAlt() ?? '') ?>"
            required
        >
    </div>

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

    <div class="col-12 pt-2">
        <button class="btn btn-primary">
            Enregistrer
        </button>

        <a href="index.php?page=accueil"
           class="btn btn-outline-dark ms-2"
           target="_blank">
            Voir côté site
        </a>
    </div>

</form>
