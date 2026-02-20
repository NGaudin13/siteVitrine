<?php
// views_admin/sections/home-domains.php
// Section slug attendu : home-domains
// Requiert : $blocks (indexés par slot), $selectedSlug

$b = $blocks ?? [];

function h($s): string {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

// Helpers (cohérents avec ta BDD)
$getText = function (string $slot) use ($b): string {
    $blk = $b[$slot] ?? null;
    return $blk ? (string)($blk->getText() ?? '') : '';
};
$getSrc = function (string $slot) use ($b): string {
    $blk = $b[$slot] ?? null;
    return $blk ? (string)($blk->getSrc() ?? '') : '';
};
$getAlt = function (string $slot) use ($b): string {
    $blk = $b[$slot] ?? null;
    return $blk ? (string)($blk->getAlt() ?? '') : '';
};

// Base
$title = $getText('title');
$intro = $getText('intro');

// Domaines : on autorise max 9
$MAX = 9;
$items = [];

for ($i = 1; $i <= $MAX; $i++) {
    $t   = $getText("domain_{$i}_title");
    $d   = $getText("domain_{$i}_desc");
    $src = $getSrc("domain_{$i}_img");
    $alt = $getAlt("domain_{$i}_img"); // ✅ ALT = colonne alt du block img

    if ($t === '' && $d === '' && $src === '' && $alt === '') continue;

    $items[] = [
        'i'   => $i,
        't'   => $t,
        'd'   => $d,
        'src' => $src,
        'alt' => $alt,
    ];
}
?>

<!-- ================= APERÇU ================= -->
<div class="p-3 rounded-3 bg-light border mb-4">
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
        <div style="max-width: 860px;">
            <div class="h5 mb-2"><?= h($title) ?></div>
            <p class="text-muted mb-0"><?= nl2br(h($intro)) ?></p>
        </div>

        <div class="text-muted small">
            <div><strong>Section :</strong> Domaines d’intervention</div>
            <div><strong>Limite :</strong> <?= (int)$MAX ?> cartes</div>
        </div>
    </div>

    <hr class="my-3">

    <?php if (empty($items)): ?>
        <div class="text-muted small">Aucun domaine configuré pour le moment.</div>
    <?php else: ?>
        <div class="row g-3">
            <?php foreach ($items as $it): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="p-2 bg-white border rounded-3 h-100">
                        <?php if (!empty($it['src'])): ?>
                            <img src="<?= h($it['src']) ?>"
                                 alt="<?= h($it['alt']) ?>"
                                 class="img-fluid rounded-3 mb-2"
                                 style="height:140px; width:100%; object-fit:cover;"
                                 loading="lazy">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center bg-light rounded-3 mb-2"
                                 style="height:140px;">
                                <span class="text-muted small">Aucune image</span>
                            </div>
                        <?php endif; ?>

                        <div class="fw-semibold"><?= h($it['t']) ?></div>
                        <div class="text-muted small"><?= h($it['d']) ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- ================= FORMULAIRE ================= -->
<form method="post"
      enctype="multipart/form-data"
      action="index.php?page=adminAccueil&section=<?= urlencode($selectedSlug) ?>"
      class="row g-4"
      id="domainsForm">

    <input type="hidden" name="section_slug" value="<?= h($selectedSlug) ?>">

    <!-- Bloc header -->
    <div class="col-12">
        <div class="p-3 border rounded-3 bg-white">
            <div class="h6 mb-1">Paramètres du bloc</div>
            <div class="text-muted small mb-3">
                Régle le titre global et le texte d’introduction affichés au-dessus des cartes.
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Titre (H2)</label>
                    <input type="text" class="form-control" name="title" value="<?= h($title) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Intro</label>
                    <input type="text" class="form-control" name="intro" value="<?= h($intro) ?>" required>
                </div>
            </div>
        </div>
    </div>

    <!-- Domaines list -->
    <div class="col-12">
        <div class="p-3 border rounded-3 bg-white">

            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap mb-2">
                <div>
                    <div class="h6 mb-1">Cartes “domaines”</div>
                    <div class="text-muted small mb-0">
                        <strong>Titre</strong> = texte dans l’overlay (sur l’image).<br>
                        <strong>Description</strong> = texte sous l’image.<br>
                        <strong>Alt</strong> = description de l’image (accessibilité + SEO).<br>
                        Le <strong>src</strong> est le chemin du fichier image (mis à jour automatiquement via upload).
                    </div>
                </div>

                <button type="button" class="btn btn-outline-primary btn-sm" id="btnAddDomain">
                    + Ajouter un domaine
                </button>
            </div>

            <div class="text-muted small mb-3">
                Astuce : tu peux réordonner avec ↑ ↓. Max <strong><?= (int)$MAX ?></strong> cartes.
            </div>

            <div class="list-group" id="domainsList">
                <?php foreach ($items as $it): ?>
                    <?php $i = (int)$it['i']; ?>
                    <div class="list-group-item domain-item" data-i="<?= $i ?>">
                        <div class="d-flex align-items-start gap-3 flex-wrap">

                            <!-- Réordre -->
                            <div class="d-flex flex-column gap-1">
                                <button type="button" class="btn btn-outline-secondary btn-sm js-move-up" title="Monter">↑</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm js-move-down" title="Descendre">↓</button>
                            </div>

                            <div class="flex-grow-1">
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label mb-1">Titre (overlay)</label>
                                        <input type="text" class="form-control"
                                               name="domains[<?= $i ?>][title]"
                                               value="<?= h($it['t']) ?>"
                                               placeholder="Ex : Stations d’épuration"
                                               required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label mb-1">Texte alternatif (alt)</label>
                                        <input type="text" class="form-control"
                                               name="domains[<?= $i ?>][alt]"
                                               value="<?= h($it['alt']) ?>"
                                               placeholder="Ex : Station d’épuration industrielle"
                                               required>
                                        <div class="form-text">
                                            L’<code>alt</code> sert à décrire l’image (lecteurs d’écran) et aide le référencement.
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label mb-1">Description</label>
                                        <textarea class="form-control"
                                                  name="domains[<?= $i ?>][desc]"
                                                  rows="2"
                                                  placeholder="Texte affiché sous l’image"
                                                  required><?= h($it['d']) ?></textarea>
                                    </div>

                                    <div class="col-md-7">
                                        <label class="form-label mb-1">Image (src)</label>

                                        <input type="text" class="form-control"
                                               value="<?= h($it['src']) ?>"
                                               readonly>

                                        <input type="hidden"
                                               name="domains[<?= $i ?>][image_src]"
                                               value="<?= h($it['src']) ?>">

                                        <div class="form-text">
                                            Le <code>src</code est le chemin vers l’image. Si tu upload une nouvelle image, le <code>src</code> sera remplacé.
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <label class="form-label mb-1">Uploader une image</label>
                                        <input type="file"
                                               class="form-control"
                                               name="domains[<?= $i ?>][image_file]"
                                               accept="image/jpeg,image/png,image/webp">
                                        <div class="form-text">
                                            JPG/PNG/WEBP — si tu upload, le <code>src</code> sera mis à jour.
                                        </div>
                                    </div>

                                    <?php if (!empty($it['src'])): ?>
                                        <div class="col-12">
                                            <img src="<?= h($it['src']) ?>"
                                                 alt="<?= h($it['alt']) ?>"
                                                 class="img-fluid rounded-3 border"
                                                 style="max-height:160px; width:100%; object-fit:cover;"
                                                 loading="lazy">
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>

                            <!-- Supprimer -->
                            <div class="text-end">
                                <button type="button" class="btn btn-outline-danger btn-sm js-remove-row">
                                    Supprimer
                                </button>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (empty($items)): ?>
                <div class="text-muted small mt-2">
                    Aucun domaine. Clique sur “+ Ajouter un domaine”.
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Actions -->
    <div class="col-12 pt-2">
        <button class="btn btn-primary">Enregistrer</button>

        <a href="index.php?page=accueil"
           class="btn btn-outline-dark ms-2"
           target="_blank">
            Voir côté site
        </a>
    </div>
</form>

<script>
(function () {
  const MAX = <?= (int)$MAX ?>;
  const list = document.getElementById('domainsList');

  function countItems() {
    return list.querySelectorAll('.domain-item').length;
  }

  function getExistingIndexes() {
    return Array.from(list.querySelectorAll('.domain-item[data-i]'))
      .map(el => parseInt(el.getAttribute('data-i'), 10))
      .filter(n => !isNaN(n));
  }

  function getNextIndex() {
    // plus petit index libre entre 1..MAX (utile si suppression au milieu)
    const used = new Set(getExistingIndexes());
    for (let i = 1; i <= MAX; i++) {
      if (!used.has(i)) return i;
    }
    return null;
  }

  // Réordre / supprimer
  document.addEventListener('click', function (e) {
    const up = e.target.closest('.js-move-up');
    const down = e.target.closest('.js-move-down');
    const remove = e.target.closest('.js-remove-row');

    if (remove) {
      const item = remove.closest('.domain-item');
      if (item) item.remove();
      return;
    }

    if (up) {
      const item = up.closest('.domain-item');
      const prev = item?.previousElementSibling;
      if (item && prev) list.insertBefore(item, prev);
      return;
    }

    if (down) {
      const item = down.closest('.domain-item');
      const next = item?.nextElementSibling;
      if (item && next) list.insertBefore(next, item);
      return;
    }
  });

  // Ajouter
  document.getElementById('btnAddDomain')?.addEventListener('click', function () {
    if (countItems() >= MAX) {
      alert('Limite atteinte : ' + MAX + ' domaines maximum.');
      return;
    }

    const i = getNextIndex();
    if (!i) {
      alert('Impossible de trouver un index libre (1..' + MAX + ').');
      return;
    }

    const div = document.createElement('div');
    div.className = 'list-group-item domain-item';
    div.setAttribute('data-i', String(i));

    div.innerHTML = `
      <div class="d-flex align-items-start gap-3 flex-wrap">

        <div class="d-flex flex-column gap-1">
          <button type="button" class="btn btn-outline-secondary btn-sm js-move-up" title="Monter">↑</button>
          <button type="button" class="btn btn-outline-secondary btn-sm js-move-down" title="Descendre">↓</button>
        </div>

        <div class="flex-grow-1">
          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label mb-1">Titre (overlay)</label>
              <input type="text" class="form-control"
                     name="domains[${i}][title]"
                     placeholder="Ex : Stations d’épuration"
                     required>
            </div>

            <div class="col-md-6">
              <label class="form-label mb-1">Texte alternatif (alt)</label>
              <input type="text" class="form-control"
                     name="domains[${i}][alt]"
                     placeholder="Ex : Station d’épuration industrielle"
                     required>
              <div class="form-text">
                L’<code>alt</code> sert à décrire l’image (accessibilité + SEO).
              </div>
            </div>

            <div class="col-12">
              <label class="form-label mb-1">Description</label>
              <textarea class="form-control"
                        name="domains[${i}][desc]"
                        rows="2"
                        placeholder="Texte affiché sous l’image"
                        required></textarea>
            </div>

            <div class="col-md-7">
              <label class="form-label mb-1">Image (src)</label>
              <input type="text" class="form-control" value="" readonly>
              <input type="hidden" name="domains[${i}][image_src]" value="">
              <div class="form-text">
                Le <code>src</code> se remplira automatiquement après upload.
              </div>
            </div>

            <div class="col-md-5">
              <label class="form-label mb-1">Uploader une image</label>
              <input type="file"
                     class="form-control"
                     name="domains[${i}][image_file]"
                     accept="image/jpeg,image/png,image/webp">
              <div class="form-text">
                JPG/PNG/WEBP — si tu upload, le <code>src</code> sera mis à jour.
              </div>
            </div>

          </div>
        </div>

        <div class="text-end">
          <button type="button" class="btn btn-outline-danger btn-sm js-remove-row">Supprimer</button>
        </div>

      </div>
    `;
    list.prepend(div);

  });

})();
</script>