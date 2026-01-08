<?php
// SEO (si ton controller ne les définit pas déjà)
$pageTitle = $pageTitle ?? "Présentation | OFLABIM";
$metaDesc  = $metaDesc  ?? "Découvrez OFLABIM : bureau d’études & ingénierie BIM. Coordination, structures et accompagnement de projets.";
$canonical = $canonical ?? "http://localhost/siteVitrine/index.php?page=presentation";

require_once(PATH_VIEWS . 'header.php');
?>

<?php require_once(PATH_VIEWS . 'alert.php'); ?>

<!-- ================= PRÉSENTATION / HERO ================= -->
<section
  class="header-presentation mt-4 py-5 mb-5"
  style="
    background-image: url('https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1600&q=80');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  "
>
  <div class="container py-4">
    <h1 class="display-5 text-white mb-2">Présentation</h1>
    <p class="lead text-white-50 mb-0" style="max-width: 760px;">
      Bureau d’Études & Ingénierie BIM — coordination, modélisation et accompagnement technique de vos projets.
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

        <p class="presentation-about__kicker text-uppercase text-muted mb-2">
          À propos
        </p>

        <h2 class="presentation-about__title mb-3">
          Bureau d’Études & Ingénierie BIM
        </h2>

        <p class="presentation-about__text text-muted mb-4">
          La construction évolue : le <strong>BIM</strong> place la maquette numérique 3D au cœur du projet,
          de la conception à l’exécution. Chez <strong>Bim Building</strong>, nous accompagnons cette transition
          avec une approche orientée qualité, coordination et performance. Notre rôle : structurer l’information,
          fluidifier la collaboration et sécuriser les décisions techniques.
        </p>

        <p class="presentation-about__text text-muted mb-4">
          Spécialisés en <strong>génie civil</strong> et en <strong>coordination BIM</strong>, nous intervenons sur
          des projets <strong>béton armé</strong>, <strong>métalliques</strong> et <strong>ossature bois</strong>,
          en lien étroit avec architectes, bureaux d’études, installateurs techniques et maîtres d’ouvrage.
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
            <li class="presentation-about__domain">Construction</li>
            <li class="presentation-about__domain">Architecture</li>
            <li class="presentation-about__domain">Structure</li>
            <li class="presentation-about__domain">HVAC / Plomberie / Électricité</li>
            <li class="presentation-about__domain">Coordination</li>
            <li class="presentation-about__domain">Facility Management</li>
        </ul>
        

      </div>
    </div>

  </div>
</section>

<!-- ================= PRÉSENTATION / PARCOURS VERSION CV ================= -->
<section class="presentation-path py-5">
  <div class="container">

    <div class="row align-items-stretch g-4">

      <!-- ===== COL 1 : EXPÉRIENCE PRO ===== -->
      <div class="col-lg-4 d-flex">
        <div class="presentation-path__panel h-100 p-4 rounded-4 bg-light">

          <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h4 mb-0">Expérience professionnelle</h2>
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

          <!-- Haut -->
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

          <!-- Centre -->
          <div class="flex-grow-1 d-flex flex-column justify-content-center">
            <h3 class="h5 mb-2">Votre expert BIM & structure</h3>

            <p class="text-muted mb-0">
              Ingénieur orienté résultats, il accompagne les projets de la conception à l’exécution
              avec une approche claire : <strong>coordination</strong>, <strong>qualité des livrables</strong>
              et <strong>communication</strong> entre tous les intervenants.
            </p>
          </div>

          <!-- Bas -->
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
            <h2 class="h4 mb-0">Parcours universitaire</h2>
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

<!-- ================= PRÉSENTATION / PARCOURS VERSION ENTREPRISE ================= -->
<section class="presentation-path py-5">
  <div class="container">

    <div class="row align-items-stretch g-4">

      <!-- ===== COL 1 : RÉALISATIONS & EXPÉRIENCE ===== -->
      <div class="col-lg-4 d-flex">
        <div class="presentation-path__panel h-100 p-4 rounded-4 bg-light">

          <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h4 mb-0">Réalisations & expérience</h2>
            <span class="presentation-path__pill badge text-bg-dark">Projets</span>
          </div>

          <p class="text-muted mb-4">
            Des missions menées sur le terrain, avec une approche orientée coordination, méthode et livrables fiables.
          </p>

          <div class="presentation-path__timeline">

            <div class="presentation-path__item d-flex gap-3">
              <div class="presentation-path__dot bg-success flex-shrink-0"></div>
              <div>
                <div class="fw-semibold">Coordination BIM</div>
                <div class="text-muted small">Pilotage de maquettes, coordination multi-lots, synthèse.</div>
                <div class="text-muted small">2012 – Aujourd’hui</div>
              </div>
            </div>

            <div class="presentation-path__item d-flex gap-3">
              <div class="presentation-path__dot bg-success flex-shrink-0"></div>
              <div>
                <div class="fw-semibold">Ingénierie structure</div>
                <div class="text-muted small">Études techniques, notes de calcul, optimisation structure.</div>
                <div class="text-muted small">2010 – 2012</div>
              </div>
            </div>

            <div class="presentation-path__item d-flex gap-3">
              <div class="presentation-path__dot bg-success flex-shrink-0"></div>
              <div>
                <div class="fw-semibold">Modélisation & plans</div>
                <div class="text-muted small">Modélisation 3D, plans d’exécution, quantitatifs.</div>
                <div class="text-muted small">2008 – 2010</div>
              </div>
            </div>

            <div class="presentation-path__item d-flex gap-3">
              <div class="presentation-path__dot bg-success flex-shrink-0"></div>
              <div>
                <div class="fw-semibold">Bureau d’études</div>
                <div class="text-muted small">Méthodes, relevés, dossiers techniques.</div>
                <div class="text-muted small">2007</div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- ===== COL 2 : ÉQUIPE / APPROCHE (CENTRAL) ===== -->
      <div class="col-lg-4 d-flex">
        <div class="presentation-path__profile h-100 p-4 rounded-4 border bg-white d-flex flex-column text-center">

          <!-- Haut : visuel entreprise -->
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

          <!-- Centre : texte entreprise -->
          <div class="flex-grow-1 d-flex flex-column justify-content-center">
            <h3 class="h5 mb-2">Une expertise réunie au sein du bureau</h3>

            <p class="text-muted mb-0">
              OFLABIM mobilise des compétences en <strong>BIM</strong> et <strong>ingénierie structure</strong>
              pour accompagner vos projets de la conception à l’exécution :
              coordination, qualité des livrables, et communication fluide avec l’ensemble des intervenants.
            </p>
          </div>

          <!-- Bas : tags compétences -->
          <div class="mt-3">
            <div class="presentation-path__profile-tags d-flex flex-wrap justify-content-center gap-2">
              <span class="badge rounded-pill text-bg-light border">Coordination BIM</span>
              <span class="badge rounded-pill text-bg-light border">Structures béton</span>
              <span class="badge rounded-pill text-bg-light border">Structures métal</span>
              <span class="badge rounded-pill text-bg-light border">Ossature bois</span>
            </div>
          </div>

        </div>
      </div>

      <!-- ===== COL 3 : COMPÉTENCES & FORMATIONS ===== -->
      <div class="col-lg-4 d-flex">
        <div class="presentation-path__panel h-100 p-4 rounded-4 bg-light">

          <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h4 mb-0">Compétences & formations</h2>
            <span class="presentation-path__pill badge text-bg-dark">Méthode</span>
          </div>

          <p class="text-muted mb-4">
            Des compétences internes solides, renforcées par une spécialisation BIM et structure.
          </p>

          <div class="presentation-path__edu">

            <div class="presentation-path__edu-card p-3 rounded-3 bg-white border mb-3">
              <div class="d-flex align-items-start gap-3">
                <div class="presentation-path__edu-icon bg-dark text-white rounded d-flex align-items-center justify-content-center flex-shrink-0">
                  <i class="bi bi-mortarboard"></i>
                </div>
                <div>
                  <div class="fw-semibold">BIM — Coordination & méthodes</div>
                  <div class="text-muted small">Process, BEP, standards, structuration des maquettes.</div>
                  <div class="text-muted small">Niveau : avancé</div>
                </div>
              </div>
            </div>

            <div class="presentation-path__edu-card p-3 rounded-3 bg-white border mb-3">
              <div class="d-flex align-items-start gap-3">
                <div class="presentation-path__edu-icon bg-dark text-white rounded d-flex align-items-center justify-content-center flex-shrink-0">
                  <i class="bi bi-journal-check"></i>
                </div>
                <div>
                  <div class="fw-semibold">Génie civil — Structures</div>
                  <div class="text-muted small">Dimensionnement, notes de calcul, optimisation.</div>
                  <div class="text-muted small">Niveau : confirmé</div>
                </div>
              </div>
            </div>

            <div class="presentation-path__edu-card p-3 rounded-3 bg-white border mb-3">
              <div class="d-flex align-items-start gap-3">
                <div class="presentation-path__edu-icon bg-dark text-white rounded d-flex align-items-center justify-content-center flex-shrink-0">
                  <i class="bi bi-award"></i>
                </div>
                <div>
                  <div class="fw-semibold">Structure métal & bois</div>
                  <div class="text-muted small">Conception, détails, plans d’exécution.</div>
                  <div class="text-muted small">Niveau : confirmé</div>
                </div>
              </div>
            </div>

            <div class="presentation-path__edu-card p-3 rounded-3 bg-white border">
              <div class="d-flex align-items-start gap-3">
                <div class="presentation-path__edu-icon bg-dark text-white rounded d-flex align-items-center justify-content-center flex-shrink-0">
                  <i class="bi bi-book"></i>
                </div>
                <div>
                  <div class="fw-semibold">Qualité & livrables</div>
                  <div class="text-muted small">Nommage, versions, livrables exploitables.</div>
                  <div class="text-muted small">Niveau : structuré</div>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>

    </div>
  </div>
</section>




<?php require_once(PATH_VIEWS . 'footer.php'); ?>
