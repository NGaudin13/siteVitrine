<?php
// views_admin/sections/home-bim.php

// Récup blocs par slot
$b = $blocks ?? [];

$title = $b['title']  ?? null;
$text1 = $b['text_1'] ?? null;
$text2 = $b['text_2'] ?? null;
$image = $b['image']  ?? null;
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

            <p class="text-muted mb-0">
                <?= nl2br(htmlspecialchars($text2?->getText() ?? '')) ?>
            </p>
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

    <div class="col-12">
        <label class="form-label">Paragraphe 2</label>
        <textarea class="form-control" name="text_2" rows="6" required><?= htmlspecialchars($text2?->getText() ?? '') ?></textarea>
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
