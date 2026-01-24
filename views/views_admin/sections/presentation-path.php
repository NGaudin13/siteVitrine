<?php
// views_admin/sections/presentation-path.php
// Section slug attendu : presentation-path
// Requiert : $blocks (indexés par slot), $selectedSlug

$b = $blocks ?? [];

// helpers
$getText = function (string $slot) use ($b): string {
    $blk = $b[$slot] ?? null;
    return $blk ? (string)($blk->getText() ?? '') : '';
};

// Base (titres + intro)
$col1Title = $getText('col1_title');
$col1Intro = $getText('col1_intro');

$col3Title = $getText('col3_title');
$col3Intro = $getText('col3_intro');

// Récupérer les listes existantes à partir des slots timeline_X_ et edu_X_
$timelineItems = [];
for ($i = 1; $i <= 50; $i++) {
    $t  = $getText("timeline_{$i}_title");
    $d  = $getText("timeline_{$i}_desc");
    $dt = $getText("timeline_{$i}_date");
    if ($t === '' && $d === '' && $dt === '') {
        continue;
    }
    $timelineItems[] = ['title' => $t, 'desc' => $d, 'date' => $dt];
}

$eduItems = [];
for ($i = 1; $i <= 50; $i++) {
    $t   = $getText("edu_{$i}_title");
    $d   = $getText("edu_{$i}_desc");
    $lvl = $getText("edu_{$i}_level");
    if ($t === '' && $d === '' && $lvl === '') {
        continue;
    }
    $eduItems[] = ['title' => $t, 'desc' => $d, 'level' => $lvl];
}
?>

<form method="post"
      action="index.php?page=adminPresentation&section=<?= urlencode($selectedSlug) ?>"
      class="row g-4">

    <input type="hidden" name="section_slug" value="<?= htmlspecialchars($selectedSlug) ?>">

    <!-- ================== Réalisations & expérience ================== -->
    <div class="col-12">
        <div class="p-3 border rounded-3 bg-white">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="h6 mb-0">Réalisations & expérience</div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="btnAddTimeline">+ Ajouter</button>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Titre du bloc</label>
                    <input type="text" class="form-control" name="col1_title" value="<?= htmlspecialchars($col1Title) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Intro</label>
                    <input type="text" class="form-control" name="col1_intro" value="<?= htmlspecialchars($col1Intro) ?>" required>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width:28%">Titre</th>
                            <th style="width:44%">Description</th>
                            <th style="width:18%">Dates</th>
                            <th style="width:10%" class="text-end">—</th>
                        </tr>
                    </thead>
                    <tbody id="timelineTbody">
                        <?php foreach ($timelineItems as $idx => $it): ?>
                            <?php $i = $idx + 1; ?>
                            <tr data-i="<?= $i ?>">
                                <td>
                                    <input type="text" class="form-control"
                                           name="timeline[<?= $i ?>][title]"
                                           value="<?= htmlspecialchars($it['title']) ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                           name="timeline[<?= $i ?>][desc]"
                                           value="<?= htmlspecialchars($it['desc']) ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                           name="timeline[<?= $i ?>][date]"
                                           value="<?= htmlspecialchars($it['date']) ?>">
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-outline-danger btn-sm js-remove-row">
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if (empty($timelineItems)): ?>
                <div class="text-muted small mt-2">Aucune expérience enregistrée. Clique sur “+ Ajouter”.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ================== Compétences & formations ================== -->
    <div class="col-12">
        <div class="p-3 border rounded-3 bg-white">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="h6 mb-0">Compétences & formations</div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="btnAddEdu">+ Ajouter</button>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Titre du bloc</label>
                    <input type="text" class="form-control" name="col3_title" value="<?= htmlspecialchars($col3Title) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Intro</label>
                    <input type="text" class="form-control" name="col3_intro" value="<?= htmlspecialchars($col3Intro) ?>" required>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width:28%">Titre</th>
                            <th style="width:44%">Description</th>
                            <th style="width:18%">Niveau</th>
                            <th style="width:10%" class="text-end">—</th>
                        </tr>
                    </thead>
                    <tbody id="eduTbody">
                        <?php foreach ($eduItems as $idx => $it): ?>
                            <?php $i = $idx + 1; ?>
                            <tr data-i="<?= $i ?>">
                                <td>
                                    <input type="text" class="form-control"
                                           name="edu[<?= $i ?>][title]"
                                           value="<?= htmlspecialchars($it['title']) ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                           name="edu[<?= $i ?>][desc]"
                                           value="<?= htmlspecialchars($it['desc']) ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                           name="edu[<?= $i ?>][level]"
                                           value="<?= htmlspecialchars($it['level']) ?>">
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-outline-danger btn-sm js-remove-row">
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if (empty($eduItems)): ?>
                <div class="text-muted small mt-2">Aucune compétence/formation enregistrée. Clique sur “+ Ajouter”.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ================== Actions ================== -->
    <div class="col-12 pt-2">
        <button class="btn btn-primary">Enregistrer</button>

        <a href="index.php?page=presentation"
           class="btn btn-outline-dark ms-2"
           target="_blank">
            Voir côté site
        </a>
    </div>
</form>

<script>
(function () {
  // supprimer une ligne = retirer la row du DOM (et donc elle ne sera pas postée)
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('.js-remove-row');
    if (!btn) return;
    const tr = btn.closest('tr');
    if (tr) tr.remove();
  });

  function getNextIndex(tbodyId) {
    const tbody = document.getElementById(tbodyId);
    let max = 0;
    tbody.querySelectorAll('tr[data-i]').forEach(tr => {
      const i = parseInt(tr.getAttribute('data-i'), 10);
      if (i > max) max = i;
    });
    return max + 1;
  }

  // ajouter timeline
  document.getElementById('btnAddTimeline')?.addEventListener('click', function () {
    const tbody = document.getElementById('timelineTbody');
    const i = getNextIndex('timelineTbody');

    const tr = document.createElement('tr');
    tr.setAttribute('data-i', String(i));
    tr.innerHTML = `
      <td><input type="text" class="form-control" name="timeline[${i}][title]" placeholder="Titre"></td>
      <td><input type="text" class="form-control" name="timeline[${i}][desc]" placeholder="Description"></td>
      <td><input type="text" class="form-control" name="timeline[${i}][date]" placeholder="Dates"></td>
      <td class="text-end">
        <button type="button" class="btn btn-outline-danger btn-sm js-remove-row">Supprimer</button>
      </td>
    `;
    tbody.appendChild(tr);
  });

  // ajouter edu
  document.getElementById('btnAddEdu')?.addEventListener('click', function () {
    const tbody = document.getElementById('eduTbody');
    const i = getNextIndex('eduTbody');

    const tr = document.createElement('tr');
    tr.setAttribute('data-i', String(i));
    tr.innerHTML = `
      <td><input type="text" class="form-control" name="edu[${i}][title]" placeholder="Titre"></td>
      <td><input type="text" class="form-control" name="edu[${i}][desc]" placeholder="Description"></td>
      <td><input type="text" class="form-control" name="edu[${i}][level]" placeholder="Niveau"></td>
      <td class="text-end">
        <button type="button" class="btn btn-outline-danger btn-sm js-remove-row">Supprimer</button>
      </td>
    `;
    tbody.appendChild(tr);
  });
})();
</script>
