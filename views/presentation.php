<?php
    // SEO (si ton controller ne les définit pas déjà)
    $pageTitle = $pageTitle ?? "Présentation | OFLABIM";
    $metaDesc  = $metaDesc  ?? "Découvrez OFLABIM : bureau d’études & ingénierie BIM. Coordination, structures et accompagnement de projets.";
    $canonical = $canonical ?? "http://localhost/siteVitrine/index.php?page=presentation";
?>

<?php require_once(PATH_VIEWS . 'alert.php'); ?>

<!-- ================= PRÉSENTATION / HERO ================= -->
<section
    class="header-presentation page-hero mt-4 py-5 mb-5"
    style="
    background-image: url('/siteVitrine/assets/images/presentation2.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    "
>
    <div class="container py-4">

        <h1 class="display-4 text-white mb-2">
            Présentation de l’entreprise
        </h1>

        <h2 class="h3 text-white mb-3">
            De la donnée à la décision
        </h2>

        <p class="lead text-white-50 mb-0" style="max-width: 760px;">
            Bureau d’Études & Ingénierie BIM — modélisation, structuration des données
            et accompagnement technique pour des projets fiables et maîtrisés.
        </p>

    </div>
</section>

<!-- ================= PRÉSENTATION / À PROPOS ================= -->
<section class="presentation-about py-5">
    <div class="container">

        <div class="row g-5">

            <!-- LEFT: IMAGE -->
            <div class="col-lg-6 d-flex">
                <div class="presentation-about__media flex-fill">
                    <img
                        class="presentation-about__img"
                        src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1400&q=80"
                        alt="Bâtiment moderne - façade"
                        loading="lazy"
                    >
                </div>
            </div>

            <!-- ===== RIGHT: TEXTE ===== --> 
            <div class="col-lg-6">

                <span class="presentation-about__kicker badge text-bg-light text-uppercase h2 px-3 py-2">
                    A propose de nous
                </span>

                <h2 class="presentation-about__title display-6 fw-bold mb-3">
                    Bureau d’Études & Ingénierie BIM
                </h2>

                <p class="presentation-about__text text-muted mb-4">
                    La construction évolue : le <strong>BIM</strong> place la maquette numérique 3D au cœur du projet,
                    de la conception à l’exécution. Chez <strong>OFLABIM</strong>, nous intervenons avec une approche orientée
                    <strong>qualité des données</strong> et <strong>livrables exploitables</strong>. Notre rôle : produire une maquette fiable,
                    en extraire des plans clairs, et structurer l’information pour sécuriser les décisions techniques.
                </p>

                <p class="presentation-about__text text-muted mb-4">
                    Nous réalisons des <strong>maquettes Revit</strong> à partir de documents techniques (dossiers d’études, PID,
                    schémas de principe, notes de calcul, plans d’exécution, documents fournisseurs) et pouvons modéliser
                    l’<strong>existant</strong> à partir de <strong>nuages de points</strong>. Le niveau de détail est adapté aux phases
                    <strong>AVP</strong>, <strong>PRO</strong> et <strong>EXE</strong>, selon les besoins du projet.
                </p>
                
                <p class="presentation-about__text text-muted mb-4">
                    Nous accompagnons également la mise en place de <strong>processus BIM collaboratifs</strong> (CDE / ACC),
                    et l’<strong>optimisation</strong> des maquettes : familles paramétriques, gabarits, automatisations Dynamo,
                    puis <strong>préparation des DOE numériques</strong> (nettoyage, allègement, IFC conformes).
                    L’objectif est simple : <strong>des données fiables, des documents lisibles, et des livrables prêts à être utilisés</strong>.
                </p>

                <!-- ===== 3 CARDS / POINTS CLÉS ===== -->
                <div class="row g-3 mb-3">

                    <div class="col-12 col-md-4">
                        <div class="presentation-about__card h-100 bg-light rounded-3 p-3">
                            <div class="presentation-about__icon d-inline-flex align-items-center justify-content-center bg-dark rounded mb-2">
                                <i class="fa fa-drafting-compass text-white"></i>
                            </div>
                            <h3 class="h6 mb-1">Expertise technique</h3>
                            <p class="small text-muted mb-0">
                                Des solutions solides et adaptées à chaque phase du projet.
                            </p>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="presentation-about__card h-100 bg-light rounded-3 p-3">
                            <div class="presentation-about__icon d-inline-flex align-items-center justify-content-center bg-dark rounded mb-2">
                                <i class="fa fa-cubes text-white"></i>
                            </div>
                            <h3 class="h6 mb-1">Maîtrise du BIM</h3>
                            <p class="small text-muted mb-0">
                                Coordination fluide grâce aux outils de modélisation numérique.
                            </p>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="presentation-about__card h-100 bg-light rounded-3 p-3">
                            <div class="presentation-about__icon d-inline-flex align-items-center justify-content-center bg-dark rounded mb-2">
                                <i class="fa fa-handshake text-white"></i>
                            </div>
                            <h3 class="h6 mb-1">Approche collaborative</h3>
                            <p class="small text-muted mb-0">
                                Synergie, transparence et efficacité pour sécuriser la réussite.
                            </p>
                        </div>
                    </div>

                </div>

                <!-- ===== DOMAINES ===== -->
                <ul class="presentation-about__domains list-unstyled d-flex flex-wrap gap-2 mt-4 mb-0">
                    <li class="presentation-about__domain">Modélisation BIM</li>
                    <li class="presentation-about__domain">Revit</li>
                    <li class="presentation-about__domain">Nuage de points</li>
                    <li class="presentation-about__domain">Plans PRO / EXE</li>
                    <li class="presentation-about__domain">Processus BIM / ACC</li>
                    <li class="presentation-about__domain">DOE numériques / IFC</li>
                </ul>


            </div>
        </div>

    </div>
</section>

<!-- ================= PRÉSENTATION / STRATÉGIE BIM ================= -->
<section class="presentation-strategy py-5">
    <div class="container">

        <div class="row g-5 align-items-center">

            <!-- ===== LEFT: TEXTE ===== -->
            <div class="col-lg-6">

                <span class="section-kicker badge text-bg-light text-uppercase h2 px-3 py-2">
                    Notre approche
                </span>


                <h2 class="presentation-strategy__title display-6 fw-bold mb-3">
                    Une stratégie BIM orientée projet
                </h2>

                <p class="presentation-strategy__text text-muted mb-4">
                    Le BIM n’est pas un simple outil de modélisation.
                    C’est une <strong>méthode de structuration des données</strong> qui permet de produire
                    des maquettes fiables, adaptées aux phases AVP, PRO et EXE,
                    et directement exploitables pour le projet.
                </p>

                <p class="presentation-strategy__text text-muted mb-4">
                    Chez <strong>OFLABIM</strong>, nous utilisons la maquette BIM comme un
                    <strong>support technique</strong> : modélisation à partir des documents existants,
                    production de plans clairs, structuration des processus sur ACC,
                    et préparation de livrables conformes aux exigences contractuelles.
                </p>

                <p class="presentation-strategy__text text-muted mb-0">
                    Notre approche vise à fiabiliser l’information dès le départ :
                    maquettes structurées, données cohérentes, DOE numériques optimisés et IFC maîtrisés.
                    L’objectif est simple : <strong>des documents lisibles, des données fiables
                    et des livrables prêts à être utilisés</strong>.
                </p>

            </div>

            <div class="col-lg-6 d-flex">
                <div class="presentation-strategy__video d-flex w-100 rounded-3 overflow-hidden shadow-sm">
                    <iframe
                        src="https://www.youtube.com/embed/rf2yyRjGLFU"
                        title="Stratégie BIM et coordination de projet"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen
                    ></iframe>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ================= PRÉSENTATION / PARCOURS VERSION ENTREPRISE (DYNAMIQUE) ================= -->
<section class="presentation-path py-5">
    <div class="container">

        <div class="row align-items-stretch g-4">

            <!-- ===== COL 1 : RÉALISATIONS & EXPÉRIENCE ===== -->
            <div class="col-lg-4 d-flex">
                <div class="presentation-path__panel h-100 p-4 rounded-4 bg-light">

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="h2 fw-bold mb-0">
                            <?= htmlspecialchars(
                                $sectionsContent['presentation-path']['col1_title']
                                ?? 'Réalisations & expérience'
                            ) ?>
                        </h2>

                        <span class="presentation-path__pill badge text-bg-dark">
                            <?= htmlspecialchars(
                                $sectionsContent['presentation-path']['col1_pill']
                                ?? 'Projets'
                            ) ?>
                        </span>
                    </div>

                    <p class="text-muted mb-4">
                        <?= nl2br(htmlspecialchars(
                            $sectionsContent['presentation-path']['col1_intro']
                            ?? 'Des missions menées sur le terrain, avec une approche orientée coordination, méthode et livrables fiables.'
                        )) ?>
                    </p>

                    <div class="presentation-path__timeline">
                        <?php
                        $hasTimeline = false;
                        for ($i = 1; $i <= 1000; $i++) {
                            $t  = trim((string)($sectionsContent['presentation-path']["timeline_{$i}_title"] ?? ''));
                            $d  = trim((string)($sectionsContent['presentation-path']["timeline_{$i}_desc"]  ?? ''));
                            $dt = trim((string)($sectionsContent['presentation-path']["timeline_{$i}_date"]  ?? ''));
                            if ($t === '' && $d === '' && $dt === '') continue;

                            $hasTimeline = true;
                            ?>
                            <div class="presentation-path__item d-flex gap-3">
                                <div class="presentation-path__dot bg-success flex-shrink-0"></div>
                                <div>
                                    <?php if ($t !== ''): ?>
                                        <div class="fw-semibold"><?= htmlspecialchars($t) ?></div>
                                    <?php endif; ?>

                                    <?php if ($d !== ''): ?>
                                        <div class="text-muted small"><?= htmlspecialchars($d) ?></div>
                                    <?php endif; ?>

                                    <?php if ($dt !== ''): ?>
                                        <div class="text-muted small"><?= htmlspecialchars($dt) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!$hasTimeline): ?>
                            <div class="text-muted small">Aucune expérience renseignée.</div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

             <!-- ===== COL 2 : ÉQUIPE / APPROCHE (EN DUR) ===== -->
            <div class="col-lg-4 d-flex">
                <div class="presentation-path__profile h-100 p-4 rounded-4 border bg-white d-flex flex-column text-center">

                    <div class="mb-3">
                        <div class="presentation-path__avatar-wrap mx-auto">
                            <img
                                class="presentation-path__avatar"
                                src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=600&q=80"
                                alt="Équipe et environnement de travail"
                                loading="lazy"
                            >
                        </div>
                    </div>

                    <div class="flex-grow-1 d-flex flex-column justify-content-center">
                        <h3 class="h5 mb-2">Une expertise réunie au sein du bureau</h3>

                        <p class="text-muted mb-0">
                            OFLABIM mobilise des compétences en <strong>BIM</strong> et <strong>ingénierie structure</strong>
                            pour accompagner vos projets de la conception à l’exécution :
                            coordination, qualité des livrables, et communication fluide avec l’ensemble des intervenants.
                        </p>
                    </div>

                    <div class="mt-3">
                        <div class="presentation-path__profile-tags d-flex flex-wrap justify-content-center gap-2">
                            <span class="badge rounded-pill text-bg-light border">Modélisation BIM</span>
                            <span class="badge rounded-pill text-bg-light border">Processus BIM/ACCn</span>
                            <span class="badge rounded-pill text-bg-light border">DOE numériques/IFC</span>
                            <span class="badge rounded-pill text-bg-light border">Plans PRO/EXE</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ===== COL 3 : COMPÉTENCES & FORMATIONS ===== -->
            <div class="col-lg-4 d-flex">
                <div class="presentation-path__panel h-100 p-4 rounded-4 bg-light">

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="h2 fw-bold mb-0">
                            <?= htmlspecialchars(
                                $sectionsContent['presentation-path']['col3_title']
                                ?? 'Compétences & formations'
                            ) ?>
                        </h2>

                        <span class="presentation-path__pill badge text-bg-dark">
                            <?= htmlspecialchars(
                                $sectionsContent['presentation-path']['col3_pill']
                                ?? 'Méthode'
                            ) ?>
                        </span>
                    </div>

                    <p class="text-muted mb-4">
                        <?= nl2br(htmlspecialchars(
                            $sectionsContent['presentation-path']['col3_intro']
                            ?? 'Des compétences internes solides, renforcées par une spécialisation BIM et structure.'
                        )) ?>
                    </p>

                    <div class="presentation-path__edu">
                        <?php
                        $hasEdu = false;
                        for ($i = 1; $i <= 1000; $i++) {
                            $t   = trim((string)($sectionsContent['presentation-path']["edu_{$i}_title"] ?? ''));
                            $d   = trim((string)($sectionsContent['presentation-path']["edu_{$i}_desc"]  ?? ''));
                            $lvl = trim((string)($sectionsContent['presentation-path']["edu_{$i}_level"] ?? ''));
                            if ($t === '' && $d === '' && $lvl === '') continue;

                            $hasEdu = true;
                            ?>
                            <div class="presentation-path__edu-card p-3 rounded-3 bg-white border mb-3">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="presentation-path__edu-icon bg-dark text-white rounded d-flex align-items-center justify-content-center flex-shrink-0">
                                        <i class="bi bi-mortarboard"></i>
                                    </div>
                                    <div>
                                        <?php if ($t !== ''): ?>
                                            <div class="fw-semibold"><?= htmlspecialchars($t) ?></div>
                                        <?php endif; ?>

                                        <?php if ($d !== ''): ?>
                                            <div class="text-muted small"><?= htmlspecialchars($d) ?></div>
                                        <?php endif; ?>

                                        <?php if ($lvl !== ''): ?>
                                            <div class="text-muted small"><?= htmlspecialchars($lvl) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!$hasEdu): ?>
                            <div class="text-muted small">Aucune compétence / formation renseignée.</div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= PRÉSENTATION / EXEMPLES DE MAQUETTES (TIMELINE) ================= -->
<section class="presentation-models-timeline py-5">
  <div class="container">

    <div class="text-center mx-auto mb-5" style="max-width: 860px;">
      <h2 class="display-6 fw-bold mt-2 mb-2">Exemples de maquettes que nous vous fournissons</h2>
      <p class="text-muted mb-0">
        Selon le type de projet, nous livrons des maquettes BIM adaptées aux phases AVP, PRO et EXE,
        à partir de données techniques existantes ou de relevés terrain.
        Chaque maquette est structurée, fiable et pensée pour être exploitée en production de plans,
        en processus collaboratif ou en DOE numérique.
      </p>
    </div>

    <div class="pmtl">

      <!-- 1 -->
      <article class="pmtl-item pmtl-item--left">
        <div class="pmtl-card">
          <img
            src="/siteVitrine/assets/images/presentation_modelCoordination.jpg"
            alt="Maquette BIM issue de l’existant"
            class="pmtl-img"
            loading="lazy"
          >
          <div class="pmtl-overlay"></div>

          <div class="pmtl-badges">
            <span class="pmtl-badge">AVP • PRO • EXE</span>
            <span class="pmtl-badge pmtl-badge--soft">Existant</span>
          </div>

          <div class="pmtl-content">
            <h3 class="pmtl-title">Maquette issue de l’existant</h3>
            <p class="pmtl-text">
              Modélisation réalisée sous Revit à partir de dossiers techniques, schémas,
              notes de calcul ou nuages de points, pour fiabiliser l’existant et préparer les phases AVP / PRO / EXE.
            </p>

            <ul class="pmtl-points">
              <li>Reprise de données & fiabilisation</li>
              <li>Structuration BIM</li>
              <li>Préparation PRO / EXE</li>
            </ul>
          </div>
        </div>

        <div class="pmtl-dot" aria-hidden="true"></div>
      </article>

      <!-- 2 -->
      <article class="pmtl-item pmtl-item--right">
        <div class="pmtl-card">
          <img
            src="/siteVitrine/assets/images/presentation_modelStructure.jpg"
            alt="Maquette BIM structure"
            class="pmtl-img"
            loading="lazy"
          >
          <div class="pmtl-overlay"></div>

          <div class="pmtl-badges">
            <span class="pmtl-badge">PRO • EXE</span>
            <span class="pmtl-badge pmtl-badge--soft">Structure</span>
          </div>

          <div class="pmtl-content">
            <h3 class="pmtl-title">Maquette structure</h3>
            <p class="pmtl-text">
              Maquette dédiée aux éléments porteurs, utilisée pour les études techniques et comme base
              à la production de plans clairs et exploitables en phase PRO / EXE.
            </p>

            <ul class="pmtl-points">
              <li>Base solide pour plans</li>
              <li>Études & production</li>
              <li>Cohérence des données</li>
            </ul>
          </div>
        </div>

        <div class="pmtl-dot" aria-hidden="true"></div>
      </article>

      <!-- 3 -->
      <article class="pmtl-item pmtl-item--left">
        <div class="pmtl-card">
          <img
            src="/siteVitrine/assets/images/presentation_modelExcecution.jpg"
            alt="Maquette BIM d’exécution"
            class="pmtl-img"
            loading="lazy"
          >
          <div class="pmtl-overlay"></div>

          <div class="pmtl-badges">
            <span class="pmtl-badge">EXE</span>
            <span class="pmtl-badge pmtl-badge--soft">Chantier</span>
          </div>

          <div class="pmtl-content">
            <h3 class="pmtl-title">Maquette d’exécution</h3>
            <p class="pmtl-text">
              Maquette détaillée servant de support à la production de plans guides, plans d’implantation,
              schémas fonctionnels et documents destinés au chantier.
            </p>

            <ul class="pmtl-points">
              <li>Plans guides & implantation</li>
              <li>Schémas fonctionnels</li>
              <li>Coordination chantier</li>
            </ul>
          </div>
        </div>

        <div class="pmtl-dot" aria-hidden="true"></div>
      </article>

      <!-- 4 -->
      <article class="pmtl-item pmtl-item--right">
        <div class="pmtl-card">
          <img
            src="/siteVitrine/assets/images/presentation_modelDOE.webp"
            alt="Maquette BIM DOE et exploitation"
            class="pmtl-img"
            loading="lazy"
          >
          <div class="pmtl-overlay"></div>

          <div class="pmtl-badges">
            <span class="pmtl-badge">DOE</span>
            <span class="pmtl-badge pmtl-badge--soft">Exploitation</span>
          </div>

          <div class="pmtl-content">
            <h3 class="pmtl-title">Maquette BIM DOE</h3>
            <p class="pmtl-text">
              Maquette allégée, nettoyée et structurée, avec export IFC conforme aux exigences contractuelles,
              destinée à l’exploitation, à la maintenance et à la traçabilité des données.
            </p>

            <ul class="pmtl-points">
              <li>IFC conforme</li>
              <li>Nettoyage & structuration</li>
              <li>Maintenance & traçabilité</li>
            </ul>
          </div>
        </div>

        <div class="pmtl-dot" aria-hidden="true"></div>
      </article>

    </div>
  </div>
</section>


<!-- ================= PRÉSENTATION / PARCOURS VERSION CV ================= -->
<section class="presentation-path-cv py-5">
    <div class="container">

        <div class="row align-items-stretch g-4">

            <!-- ===== COL 1 : EXPÉRIENCE PRO ===== -->
            <div class="col-lg-4 d-flex">
                <div class="presentation-path__panel h-100 p-4 rounded-4 bg-light">

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="h2 fw-bold mb-0">Expérience professionnelle</h2>
                        <span class="presentation-path__pill badge text-bg-dark">Parcours</span>
                    </div>

                    <p class="text-muted mb-4">
                        Une expérience terrain orientée coordination, méthode et livrables fiables.
                    </p>

                    <div class="presentation-path__timeline">

                        <div class="presentation-path__item d-flex gap-3">
                            <div class="presentation-path__dot bg-success flex-shrink-0"></div>
                            <div>
                                <div class="fw-semibold">BIM Manager / Coordinateur BIM</div>
                                <div class="text-muted small">Pilotage de maquettes, coordination multi-lots, synthèse.</div>
                                <div class="text-muted small">2022 – Aujourd’hui</div>
                            </div>
                        </div>

                        <div class="presentation-path__item d-flex gap-3">
                            <div class="presentation-path__dot bg-success flex-shrink-0"></div>
                            <div>
                                <div class="fw-semibold">Ingénieur Génie Civil</div>
                                <div class="text-muted small">Études techniques, notes de calcul, optimisation structure.</div>
                                <div class="text-muted small">2019 – 2022</div>
                            </div>
                        </div>

                        <div class="presentation-path__item d-flex gap-3">
                            <div class="presentation-path__dot bg-success flex-shrink-0"></div>
                            <div>
                                <div class="fw-semibold">Projeteur / Modeleur BIM</div>
                                <div class="text-muted small">Modélisation 3D, plans d’exécution, quantitatifs.</div>
                                <div class="text-muted small">2017 – 2019</div>
                            </div>
                        </div>

                        <div class="presentation-path__item d-flex gap-3">
                            <div class="presentation-path__dot bg-success flex-shrink-0"></div>
                            <div>
                                <div class="fw-semibold">Stage – Bureau d’études</div>
                                <div class="text-muted small">Découverte des méthodes, relevés, dossiers techniques.</div>
                                <div class="text-muted small">2016</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ===== COL 2 : PROFIL (CENTRAL) ===== -->
            <div class="col-lg-4 d-flex">
                <div class="presentation-path__profile h-100 p-4 rounded-4 border bg-white d-flex flex-column text-center">

                    <div class="mb-3">
                        <div class="presentation-path__avatar-wrap mx-auto">
                            <img
                                class="presentation-path__avatar"
                                src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&q=80"
                                alt="Portrait professionnel"
                                loading="lazy"
                            >
                        </div>
                    </div>

                    <div class="flex-grow-1 d-flex flex-column justify-content-center">
                        <h3 class="h5 mb-2">Votre expert BIM & structure</h3>

                        <p class="text-muted mb-0">
                            Ingénieur orienté résultats, il accompagne les projets de la conception à l’exécution
                            avec une approche claire : <strong>coordination</strong>, <strong>qualité des livrables</strong>
                            et <strong>communication</strong> entre tous les intervenants.
                        </p>
                    </div>

                    <div class="mt-3">
                        <div class="presentation-path__profile-tags d-flex flex-wrap justify-content-center gap-2">
                            <span class="badge rounded-pill text-bg-light border">Coordination BIM</span>
                            <span class="badge rounded-pill text-bg-light border">Génie civil</span>
                            <span class="badge rounded-pill text-bg-light border">Structures</span>
                            <span class="badge rounded-pill text-bg-light border">Synthèse</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ===== COL 3 : FORMATION ===== -->
            <div class="col-lg-4 d-flex">
                <div class="presentation-path__panel h-100 p-4 rounded-4 bg-light">

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="h2 fw-bold mb-0">Parcours universitaire</h2>
                        <span class="presentation-path__pill badge text-bg-dark">Formation</span>
                    </div>

                    <p class="text-muted mb-4">
                        Une base solide en ingénierie, renforcée par la spécialisation BIM.
                    </p>

                    <div class="presentation-path__edu">

                        <div class="presentation-path__edu-card p-3 rounded-3 bg-white border mb-3">
                            <div class="d-flex align-items-start gap-3">
                                <div class="presentation-path__edu-icon bg-dark text-white rounded d-flex align-items-center justify-content-center flex-shrink-0">
                                    <i class="bi bi-mortarboard"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Master 2 — Ingénierie & BIM</div>
                                    <div class="text-muted small">Gestion de projet, coordination, maquettes numériques.</div>
                                    <div class="text-muted small">2021 – 2022</div>
                                </div>
                            </div>
                        </div>

                        <div class="presentation-path__edu-card p-3 rounded-3 bg-white border mb-3">
                            <div class="d-flex align-items-start gap-3">
                                <div class="presentation-path__edu-icon bg-dark text-white rounded d-flex align-items-center justify-content-center flex-shrink-0">
                                    <i class="bi bi-journal-check"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Master 1 — Génie Civil</div>
                                    <div class="text-muted small">Structures, dimensionnement, méthodes.</div>
                                    <div class="text-muted small">2020 – 2021</div>
                                </div>
                            </div>
                        </div>

                        <div class="presentation-path__edu-card p-3 rounded-3 bg-white border mb-3">
                            <div class="d-flex align-items-start gap-3">
                                <div class="presentation-path__edu-icon bg-dark text-white rounded d-flex align-items-center justify-content-center flex-shrink-0">
                                    <i class="bi bi-award"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Licence — Génie Civil</div>
                                    <div class="text-muted small">Techniques de construction, base structure.</div>
                                    <div class="text-muted small">2017 – 2020</div>
                                </div>
                            </div>
                        </div>

                        <div class="presentation-path__edu-card p-3 rounded-3 bg-white border">
                            <div class="d-flex align-items-start gap-3">
                                <div class="presentation-path__edu-icon bg-dark text-white rounded d-flex align-items-center justify-content-center flex-shrink-0">
                                    <i class="bi bi-book"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Baccalauréat — Scientifique</div>
                                    <div class="text-muted small">Spécialité mathématiques / sciences.</div>
                                    <div class="text-muted small">2017</div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

