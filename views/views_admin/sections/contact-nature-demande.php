<?php
// views_admin/sections/contact-form.php
// Section slug attendu : contact-form
// Requiert : $blocks (indexés par slot), $selectedSlug

$b = $blocks ?? [];

// Récupérer les sujets existants à partir des slots subject_*
$subjectItems = [];

foreach ($b as $slot => $blk) {
    if (strpos($slot, 'subject_') !== 0) continue;

    $isActive = method_exists($blk, 'getIsActive') ? (int)$blk->getIsActive() : 1;
    if ($isActive !== 1) continue;

    $value = substr($slot, strlen('subject_'));
    $label = (string)($blk->getText() ?? '');
    $order = method_exists($blk, 'getOrderIndex') ? (int)$blk->getOrderIndex() : 999;

    $subjectItems[] = [
        'value' => $value,
        'label' => $label,
        'order' => $order,
    ];
}

usort($subjectItems, fn($a, $b) => $a['order'] <=> $b['order']);
?>

<form method="post"
      action="index.php?page=adminContact&section=<?= urlencode($selectedSlug) ?>"
      class="row g-4"
      id="contactSubjectsForm">

    <input type="hidden" name="section_slug" value="<?= htmlspecialchars($selectedSlug) ?>">

    <div class="col-12">
        <div class="p-3 border rounded-3 bg-white">

            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <div class="h6 mb-1">Sujets des demandes clients</div>
                    <div class="text-muted small mb-0">
                        Ajoutez, modifiez, supprimez et réordonnez les sujets visibles dans le formulaire Contact.
                    </div>
                </div>

                <button type="button" class="btn btn-outline-primary btn-sm" id="btnAddSubject">
                    + Ajouter un sujet
                </button>
            </div>

            <div class="list-group" id="subjectsList">

                <?php foreach ($subjectItems as $idx => $it): ?>
                    <?php $i = $idx + 1; ?>
                    <div class="list-group-item d-flex align-items-center gap-2 subject-item" data-i="<?= $i ?>">

                        <!-- Réordre -->
                        <div class="d-flex flex-column gap-1">
                            <button type="button" class="btn btn-outline-secondary btn-sm js-move-up" title="Monter">↑</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm js-move-down" title="Descendre">↓</button>
                        </div>

                        <!-- Libellé visible -->
                        <div class="flex-grow-1">
                            <label class="form-label mb-1">Libellé</label>
                            <input type="text"
                                   class="form-control"
                                   name="subjects[<?= $i ?>][label]"
                                   value="<?= htmlspecialchars($it['label']) ?>"
                                   placeholder="Ex : Demande de devis"
                                   required>

                            <div class="form-text">
                                Ce texte apparaît dans le menu “Sujet” sur la page Contact.
                            </div>
                        </div>

                        <!-- Hidden: value + order + active -->
                        <input type="hidden" name="subjects[<?= $i ?>][value]" value="<?= htmlspecialchars($it['value']) ?>">
                        <input type="hidden" name="subjects[<?= $i ?>][order]" value="<?= (int)$it['order'] ?>">
                        <input type="hidden" name="subjects[<?= $i ?>][active]" value="1">

                        <!-- Supprimer -->
                        <div class="text-end">
                            <button type="button" class="btn btn-outline-danger btn-sm js-remove-row">
                                Supprimer
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

            <?php if (empty($subjectItems)): ?>
                <div class="text-muted small mt-2">
                    Aucun sujet. Cliquez sur “+ Ajouter un sujet”.
                </div>
            <?php endif; ?>

        </div>
    </div>

    <div class="col-12 pt-2">
        <button class="btn btn-primary">Enregistrer</button>

        <a href="index.php?page=contact"
           class="btn btn-outline-dark ms-2"
           target="_blank">
            Voir la page Contact
        </a>
    </div>

</form>

<script>
(function () {

  const list = document.getElementById('subjectsList');
  const form = document.getElementById('contactSubjectsForm');

  function slugify(str) {
    return (str || '')
      .toLowerCase()
      .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-+|-+$/g, '')
      .replace(/-+/g, '-');
  }

  function renumberAndReorderHidden() {
    const items = Array.from(list.querySelectorAll('.subject-item'));

    items.forEach((item, idx) => {
      const i = idx + 1;
      item.setAttribute('data-i', String(i));

      // Renommer les name="subjects[i][...]"
      item.querySelectorAll('input').forEach(input => {
        const name = input.getAttribute('name');
        if (!name) return;
        input.setAttribute('name', name.replace(/^subjects\[\d+\]/, `subjects[${i}]`));
      });

      // recalculer l'ordre automatiquement : 10,20,30...
      const orderInput = item.querySelector('input[name^="subjects["][name$="[order]"]');
      if (orderInput) orderInput.value = String(i * 10);
    });
  }

  // Move up/down
  document.addEventListener('click', function (e) {
    const up = e.target.closest('.js-move-up');
    const down = e.target.closest('.js-move-down');
    const remove = e.target.closest('.js-remove-row');

    if (remove) {
      const item = remove.closest('.subject-item');
      if (item) item.remove();
      renumberAndReorderHidden();
      return;
    }

    if (up) {
      const item = up.closest('.subject-item');
      const prev = item?.previousElementSibling;
      if (item && prev) list.insertBefore(item, prev);
      renumberAndReorderHidden();
      return;
    }

    if (down) {
      const item = down.closest('.subject-item');
      const next = item?.nextElementSibling;
      if (item && next) list.insertBefore(next, item);
      renumberAndReorderHidden();
      return;
    }
  });

  // Add new
  document.getElementById('btnAddSubject')?.addEventListener('click', function () {
    const items = list.querySelectorAll('.subject-item');
    const i = items.length + 1;

    const div = document.createElement('div');
    div.className = 'list-group-item d-flex align-items-center gap-2 subject-item';
    div.setAttribute('data-i', String(i));

    div.innerHTML = `
      <div class="d-flex flex-column gap-1">
        <button type="button" class="btn btn-outline-secondary btn-sm js-move-up" title="Monter">↑</button>
        <button type="button" class="btn btn-outline-secondary btn-sm js-move-down" title="Descendre">↓</button>
      </div>

      <div class="flex-grow-1">
        <label class="form-label mb-1">Libellé</label>
        <input type="text" class="form-control"
               name="subjects[${i}][label]"
               placeholder="Ex : Demande de devis"
               required>
        <div class="form-text">Ce texte apparaît dans le menu “Sujet”.</div>
      </div>

      <input type="hidden" name="subjects[${i}][value]" value="">
      <input type="hidden" name="subjects[${i}][order]" value="${i*10}">
      <input type="hidden" name="subjects[${i}][active]" value="1">

      <div class="text-end">
        <button type="button" class="btn btn-outline-danger btn-sm js-remove-row">Supprimer</button>
      </div>
    `;

    list.appendChild(div);

    // auto value à partir du label (si vide) au blur
    const labelInput = div.querySelector(`input[name="subjects[${i}][label]"]`);
    const valueInput = div.querySelector(`input[name="subjects[${i}][value]"]`);

    labelInput?.addEventListener('blur', () => {
      if (!valueInput) return;
      if (valueInput.value.trim() === '') {
        valueInput.value = slugify(labelInput.value);
      }
    });

    renumberAndReorderHidden();
  });

  // Avant submit: garantir value non vide
  form?.addEventListener('submit', function () {
    const items = Array.from(list.querySelectorAll('.subject-item'));
    items.forEach(item => {
      const labelInput = item.querySelector('input[name$="[label]"]');
      const valueInput = item.querySelector('input[name$="[value]"]');
      if (labelInput && valueInput && valueInput.value.trim() === '') {
        valueInput.value = slugify(labelInput.value);
      }
    });
    renumberAndReorderHidden();
  });

  renumberAndReorderHidden();

})();
</script>
