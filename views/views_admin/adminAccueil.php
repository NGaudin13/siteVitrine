<?php
$pageTitle = $pageTitle ?? "Admin Accueil | OFLABIM";
$metaDesc  = $metaDesc  ?? "Administration de la page Accueil";
$canonical = $canonical ?? "http://localhost/siteVitrine/index.php?page=adminAccueil";
?>

<div class="border rounded-3 p-4 bg-white">

    <?php if (!empty($flashSuccess)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($flashSuccess) ?></div>
    <?php endif; ?>

    <?php if (!empty($flashError)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($flashError) ?></div>
    <?php endif; ?>

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h2 class="h5 mb-1">Accueil — Administration</h2>
            <p class="text-muted mb-0">Choisissez une section de la page Accueil à modifier.</p>
        </div>
    </div>

    <!-- ================= CHOIX SECTION ================= -->
    <div class="row g-3 align-items-end mb-4">
        <div class="col-md-8">
            <label class="form-label">Section à modifier</label>

            <select
                class="form-select"
                onchange="if (this.value) window.location.href='index.php?page=adminAccueil&section=' + encodeURIComponent(this.value); else window.location.href='index.php?page=adminAccueil';"
            >
                <option value="" <?= empty($selectedSlug) ? 'selected' : '' ?>>
                    — Choisir une section —
                </option>

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
                Une section est éditable seulement si elle a au moins un <code>content_block</code> associé.
            </div>
        </div>

        <div class="col-md-4 text-md-end">
            <a class="btn btn-outline-dark" href="index.php?page=accueil" target="_blank">
                Voir la page Accueil
            </a>
        </div>
    </div>

    <hr class="my-4">

    <?php if (empty($selectedSlug)): ?>

        <div class="alert alert-info mb-0">
            Choisis une section dans la liste pour commencer.
        </div>

    <?php elseif (!$isEditable): ?>

        <div class="alert alert-info mb-0">
            Cette section n’est pas encore éditable (aucun contenu associé).
        </div>

    <?php else: ?>

        <div class="mb-3">
            <h3 class="h6 mb-1">
                Section “<?= htmlspecialchars($selectedSection?->getAdminTitle() ?? '') ?>”
            </h3>
            <p class="text-muted mb-0">
                Édition de la section sélectionnée.
            </p>
        </div>

        <?php
        // ✅ UNE SEULE VUE, MAIS FORMULAIRES SPÉCIFIQUES PAR SECTION
        $adminSectionView = PATH_VIEWS_ADMIN . 'sections/' . $selectedSlug . '.php';

        if (file_exists($adminSectionView)) {
            require $adminSectionView;
        } else {
            // fallback : pas encore de formulaire dédié
            ?>
            <div class="alert alert-warning mb-0">
                Formulaire non encore créé pour cette section :
                <code><?= htmlspecialchars($selectedSlug) ?></code>
            </div>
            <?php
        }
        ?>

    <?php endif; ?>

</div>
