<?php
// =========================================================
// FICHIER : siteVitrine/views/accueil.php
// =========================================================

// Variables fournies par le contrôleur qui inclut cette vue
// (déclarées ici pour VS Code / Intelephense).
/** @var array $sectionsContent */

require_once PATH_VIEWS . 'alert.php';
?>

<!-- ================= ACCUEIL / BANDEAU =================
     Bandeau principal : ce que fait OFLABIM, en une phrase.
     Photo : celle de l'ancien carousel (modifiable ci-dessous).
     ======================================================= -->
<?php
$heroImage = 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1920&q=80';
// Autre photo possible : 'assets/images/hopitalCVC2.jpg'
?>
<section class="ofl-hero" style="--ofl-hero-img: url('<?= htmlspecialchars($heroImage, ENT_QUOTES, 'UTF-8') ?>');">
    <div class="container ofl-hero__inner">
        <div class="ofl-hero__content">

            <div class="ofl-eyebrow">Bureau d’études BIM · Installations techniques</div>

            <h1 class="ofl-hero__title">
                Vos installations techniques, <em>maîtrisées en BIM</em>
            </h1>

            <div class="ofl-hero__lead">
                Modélisation Revit, plans d’exécution, coordination et DOE numériques,
                en projet neuf comme en réhabilitation.
            </div>

            <div class="ofl-actions">
                <a class="ofl-btn ofl-btn--cta" href="index.php?page=contact#contact-form">
                    <i class="fa fa-phone-alt" aria-hidden="true"></i>
                    Demander un devis
                </a>
                <a class="ofl-btn ofl-btn--ghost" href="#reel-bim" data-demo-toggle
                   aria-controls="reel-bim" aria-expanded="true">
                    <i class="bi bi-layers" aria-hidden="true"></i>
                    <span data-demo-label>Voir la démonstration</span>
                </a>
            </div>

            <ul class="ofl-hero__sectors" aria-label="Secteurs d’intervention">
                <li>Eau potable &amp; assainissement</li>
                <li>CVC &amp; hôpitaux</li>
                <li>Industrie &amp; pharmaceutique</li>
            </ul>

        </div>
    </div>
</section>

<!-- ================= ACCUEIL / COMPARATEUR RÉEL / BIM =================
     Deux images de même format (1086 × 724) et même cadrage :
       assets/images/comparateur-reel.png  -> vue réaliste
       assets/images/comparateur-bim.png   -> vue maquette BIM
     Les repères sont en % de l'image : à replacer si les images changent.
     ==================================================================== -->
<section class="ofl-compare-sec" id="reel-bim" data-demo>
    <div class="container">
        <div class="ofl-compare-sec__bar">
            <button type="button" class="ofl-close" data-demo-close>
                <i class="bi bi-x-lg" aria-hidden="true"></i>
                Fermer la démonstration
            </button>
        </div>
        <div class="row g-5 align-items-center">

            <div class="col-lg-5">
                <div class="ofl-kicker">Du réel au numérique</div>
                <h2 class="ofl-compare-sec__title">Chaque équipement a sa place dans la maquette</h2>
                <p class="ofl-compare-sec__intro">
                    Pompes, réseaux, vannes, armoires : la maquette BIM décrit l’installation telle qu’elle
                    est ou telle qu’elle sera construite, avec ses informations techniques.
                </p>
                <ul class="ofl-gains">
                    <li>
                        <i class="bi bi-check-lg" aria-hidden="true"></i>
                        <div><strong>Moins de surprises en chantier</strong><span>Les conflits entre réseaux sont repérés dans la maquette, pas sur site.</span></div>
                    </li>
                    <li>
                        <i class="bi bi-check-lg" aria-hidden="true"></i>
                        <div><strong>Des plans cohérents</strong><span>Plans d’implantation et de manutention issus d’une seule source.</span></div>
                    </li>
                    <li>
                        <i class="bi bi-check-lg" aria-hidden="true"></i>
                        <div><strong>Un DOE exploitable</strong><span>L’exploitant retrouve chaque équipement et ses caractéristiques.</span></div>
                    </li>
                </ul>
            </div>

            <div class="col-lg-7">
                <figure class="ofl-compare">
                    <div class="ofl-compare__stage" data-comparateur>
                        <img class="ofl-compare__img" data-photo draggable="false"
                             src="assets/images/comparateur-reel.png"
                             alt="Local de pompage : pompes, collecteur bleu, vannes et armoires électriques"
                             loading="lazy">
                        <div class="ofl-compare__error" data-photo-error hidden>
                            Image introuvable : <code>assets/images/comparateur-reel.png</code>
                        </div>

                        <div class="ofl-compare__img ofl-compare__bim">
                            <img class="ofl-compare__img" src="assets/images/comparateur-bim.png" draggable="false" data-maquette
                                 alt="Le même local de pompage dans la maquette BIM" loading="lazy">
                            <div class="ofl-compare__error ofl-compare__error--bim" data-maquette-error hidden>
                                <p class="mb-0">Maquette introuvable : vérifiez que le fichier
                                <code>assets/images/comparateur-bim.png</code> est bien présent.</p>
                            </div>
                        </div>

                        <!-- Repères placés sur des éléments présents au même endroit dans les 2 images -->
                        <span class="ofl-pin" style="left:58.9%;top:20.7%"><i></i><b>Collecteur DN400</b></span>
                        <span class="ofl-pin ofl-pin--left" style="left:72.1%;top:45.6%"><i></i><b>V-03 · Vanne</b></span>
                        <span class="ofl-pin" style="left:57.5%;top:76%"><i></i><b>P-03 · Pompe</b></span>
                        <span class="ofl-pin ofl-pin--hide-sm" style="left:73.7%;top:57%"><i></i><b>Manomètre</b></span>

                        <span class="ofl-tag ofl-tag--real">Réel</span>
                        <span class="ofl-tag ofl-tag--bim">BIM</span>
                        <div class="ofl-compare__divider"></div>
                        <input class="ofl-compare__range" type="range" min="0" max="100" value="50" step="1"
                               aria-label="Faire glisser pour comparer la vue réelle et la maquette BIM">
                        <div class="ofl-compare__handle" aria-hidden="true">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>
                    </div>

                    <figcaption class="ofl-compare__caption">
                        <span class="ofl-compare__how">
                            <i class="bi bi-arrows-expand-vertical" aria-hidden="true"></i>
                            Faites glisser la poignée pour passer du réel à la maquette.
                        </span>
                    </figcaption>
                </figure>
            </div>

        </div>
    </div>
</section>

<!-- ================= ACCUEIL / LE BIM ================= -->
<section id="homeIntro" class="home-intro py-5">
    <div class="container">

        <div class="row g-5 align-items-stretch">

            <!-- TEXTE -->
            <div class="col-lg-6 d-flex">
                <div class="home-intro__content">

                    <h2 class="display-6 fw-bold mb-4">
                        <?= htmlspecialchars(
                            $sectionsContent['home-intro']['title']
                            ?? 'Le BIM, au cœur de la coordination de vos projets'
                        ) ?>
                    </h2>

                    <p class="text-muted mb-3">
                        <?= nl2br(htmlspecialchars(
                            $sectionsContent['home-intro']['text_1']
                            ?? 'Texte BIM principal'
                        )) ?>
                    </p>

                    <p class="text-muted mb-0">
                        <?= nl2br(htmlspecialchars(
                            $sectionsContent['home-intro']['text_2']
                            ?? 'Texte BIM secondaire'
                        )) ?>
                    </p>

                </div>
            </div>

            <!-- IMAGE -->
            <div class="col-lg-6 d-flex">
                <div class="home-intro__image">
                    <img
                        src="<?= htmlspecialchars(
                            $sectionsContent['home-intro']['image']['src']
                            ?? 'assets/images/accueil_homeBim2.jpg'
                        ) ?>"
                        alt="<?= htmlspecialchars(
                            $sectionsContent['home-intro']['image']['alt']
                            ?? 'Coordination BIM et travail collaboratif autour d’une maquette numérique'
                        ) ?>"
                        loading="lazy"
                    >
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= HOME / SERVICES + VALUE (3 colonnes) ================= -->
<section class="home-services-value py-5">
    <div class="container">

        <div class="row g-4 align-items-stretch">

            <!-- ===== COL 1 : PRESTATIONS ===== -->
            <div class="col-lg-4">
                <div class="home-services-value__block">

                    <h2 class="home-services-value__title display-6 fw-bold mb-3">
                        Services
                    </h2>

                    <p class="text-muted mb-4">
                        Découvrez nos services BIM et structure. Cliquez pour en savoir plus.
                    </p>

                    <div class="home-services-value__list">

                        <!-- Item -->
                        <a class="home-services-value__item d-flex align-items-start text-decoration-none p-3 rounded-3 mb-3"
                           href="index.php?page=service#service_1">
                            <div class="home-services-value__icon bg-dark text-white rounded d-flex align-items-center justify-content-center flex-shrink-0">
                                <i class="bi bi-boxes"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold text-dark">Modélisation de maquette numérique</div>
                                <div class="text-muted small">Maquettes fiables à partir des données techniques et du terrain</div>
                            </div>
                            <div class="ms-auto home-services-value__pin flex-shrink-0">
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>

                        <!-- Item -->
                        <a class="home-services-value__item d-flex align-items-start text-decoration-none p-3 rounded-3 mb-3"
                           href="index.php?page=service#service_2">
                            <div class="home-services-value__icon bg-dark text-white rounded d-flex align-items-center justify-content-center flex-shrink-0">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold text-dark">Production de pièces graphiques</div>
                                <div class="text-muted small">Documents clairs et exploitables issus des maquettes BIM</div>
                            </div>
                            <div class="ms-auto home-services-value__pin flex-shrink-0">
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>

                        <!-- Item -->
                        <a class="home-services-value__item d-flex align-items-start text-decoration-none p-3 rounded-3 mb-3"
                           href="index.php?page=service#service_3">
                            <div class="home-services-value__icon bg-dark text-white rounded d-flex align-items-center justify-content-center flex-shrink-0">
                                <i class="bi bi-wrench-adjustable"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold text-dark">Processus BIM collaboratif</div>
                                <div class="text-muted small">Structuration des maquettes et organisation des workflows sur ACC</div>
                            </div>
                            <div class="ms-auto home-services-value__pin flex-shrink-0">
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>

                        <!-- Item -->
                        <a class="home-services-value__item d-flex align-items-start text-decoration-none p-3 rounded-3"
                           href="index.php?page=service#service_4">
                            <div class="home-services-value__icon bg-dark text-white rounded d-flex align-items-center justify-content-center flex-shrink-0">
                                <i class="bi bi-tree"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold text-dark">Optimisation BIM & DOE numérique</div>
                                <div class="text-muted small">Automatisation, fiabilisation des données et production d’IFC conformes</div>
                            </div>
                            <div class="ms-auto home-services-value__pin flex-shrink-0">
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>

                    </div>
                </div>
            </div>

            <!-- ===== COL 2 : IMAGE ===== -->
            <div class="col-lg-4 d-flex">
                <div class="home-services-value__image-wrap mx-auto w-100 h-100">
                    <img
                        class="img-fluid rounded-4 home-services-value__image"
                        src="assets/images/accueil_homeServiceValue1.jpg"
                        alt="Maquette BIM et ingénierie"
                        loading="lazy"
                    >
                </div>
            </div>

            <!-- ===== COL 3 : GAGES DE QUALITÉ ===== -->
            <div class="col-lg-4">
                <div class="home-services-value__block">

                    <h2 class="home-services-value__title display-6 fw-bold mb-3">
                        Gages de qualité
                    </h2>

                    <p class="text-muted mb-4">
                        Une méthode claire, des livrables propres, et un suivi sérieux.
                    </p>

                    <div class="home-services-value__value">

                        <div class="d-flex align-items-start p-3 rounded-3 mb-3 bg-light">
                            <div class="home-services-value__badge text-success flex-shrink-0">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold">Livrables structurés</div>
                                <div class="text-muted small">Nommage, versions, fichiers propres et exploitables.</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start p-3 rounded-3 mb-3 bg-light">
                            <div class="home-services-value__badge text-success flex-shrink-0">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold">Délais tenus</div>
                                <div class="text-muted small">Planification simple, points réguliers, pas de surprise.</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start p-3 rounded-3 mb-3 bg-light">
                            <div class="home-services-value__badge text-success flex-shrink-0">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold">Communication fluide</div>
                                <div class="text-muted small">Réactivité, échanges clairs, validations rapides.</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start p-3 rounded-3 bg-light">
                            <div class="home-services-value__badge text-success flex-shrink-0">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold">Confidentialité</div>
                                <div class="text-muted small">Respect des données projet et de vos contraintes.</div>
                            </div>
                        </div><br>

                        <div class="d-flex align-items-start p-3 rounded-3 bg-light">
                            <div class="home-services-value__badge text-success flex-shrink-0">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold">Rigueur technique</div>
                                <div class="text-muted small">
                                    Respect des normes et cohérence des données.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= ACCUEIL / À PROPOS ================= -->
<section class="home-about py-5">
    <div class="container">
        <div class="row align-items-stretch g-5">

            <!-- Col gauche : texte + stats -->
            <div class="col-lg-6">
                <div class="home-about__content">

                    <h2 class="home-about__title display-6 fw-bold mb-3">
                        <?= htmlspecialchars(
                            $sectionsContent['home-about']['title']
                            ?? 'À propos de nous'
                        ) ?>
                    </h2>

                    <p class="home-about__text text-muted mb-4">
                        <?= nl2br(htmlspecialchars(
                            $sectionsContent['home-about']['text_1']
                            ?? 'Présentation de l’entreprise'
                        )) ?>
                    </p>

                    <div class="home-about__stats row g-4">

                        <div class="col-6">
                            <div class="home-about__stat">
                                <div class="home-about__number display-5 fw-bold text-primary mb-1">
                                    <?= htmlspecialchars(
                                        $sectionsContent['home-about']['stat_1_value']
                                        ?? '45+'
                                    ) ?>
                                </div>
                                <div class="home-about__label fw-semibold">
                                    Projets terminés
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="home-about__stat">
                                <div class="home-about__number display-5 fw-bold text-primary mb-1">
                                    <?= htmlspecialchars(
                                        $sectionsContent['home-about']['stat_2_value']
                                        ?? '100%'
                                    ) ?>
                                </div>
                                <div class="home-about__label fw-semibold">
                                    Clients satisfaits
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="home-about__actions mt-4 d-flex gap-2 flex-wrap">
                        <a href="index.php?page=presentation" class="btn btn-dark px-4">
                            En savoir plus
                        </a>
                        <a href="index.php?page=service" class="btn btn-outline-dark px-4">
                            Nos services
                        </a>
                    </div>

                </div>
            </div>

            <!-- Col droite : image -->
            <div class="col-lg-6">
                <div class="home-about__media position-relative">
                    <img
                        class="home-about__img img-fluid rounded-3 shadow-sm w-100"
                        src="<?= htmlspecialchars(
                            $sectionsContent['home-about']['image']['src']
                            ?? 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1400&q=70'
                        ) ?>"
                        alt="<?= htmlspecialchars(
                            $sectionsContent['home-about']['image']['alt']
                            ?? 'Bureau d’études et ingénierie BIM'
                        ) ?>"
                        loading="lazy"
                    >
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= DOMAINES D’INTERVENTION ================= -->
<section class="home-domains py-5">
    <div class="container">

        <div class="text-center mx-auto mb-5" style="max-width: 820px;">
            <h2 class="display-6 fw-bold mb-2">
                <?= htmlspecialchars(
                    $sectionsContent['home-domains']['title']
                    ?? 'Domaines d’intervention'
                ) ?>
            </h2>

            <p class="text-muted mb-0">
                <?= nl2br(htmlspecialchars(
                    $sectionsContent['home-domains']['intro']
                    ?? "OFLABIM accompagne des projets techniques et industriels complexes,\nnécessitant une forte maîtrise des méthodes BIM et de la coordination."
                )) ?>
            </p>
        </div>

        <div class="row g-4">
            <?php
            $sd = $sectionsContent['home-domains'] ?? [];

            // 1) Si tu as déjà un tableau "domains"
            $domains = $sd['domains'] ?? null;

            // 2) Sinon, on reconstruit depuis domain_1_..., domain_2_..., etc (max 9)
            if (!is_array($domains)) {
                $domains = [];
                for ($i = 1; $i <= 9; $i++) {
                    $t = $sd["domain_{$i}_title"] ?? '';
                    $d = $sd["domain_{$i}_desc"] ?? '';

                    $img = $sd["domain_{$i}_img"] ?? [];
                    $src = is_array($img) ? ($img['src'] ?? '') : '';
                    $alt = is_array($img) ? ($img['alt'] ?? '') : '';

                    if (trim($t) === '' || trim($d) === '' || trim($src) === '') {
                        continue;
                    }

                    if (trim($alt) === '') {
                        $alt = $t; // fallback propre
                    }

                    $domains[] = [
                        'title' => $t,
                        'desc'  => $d,
                        'img'   => ['src' => $src, 'alt' => $alt],
                    ];
                }
            }

            // Affichage
            foreach ($domains as $dom):
                $title = (string)($dom['title'] ?? '');
                $desc  = (string)($dom['desc'] ?? '');

                $img   = $dom['img'] ?? [];
                $src   = is_array($img) ? (string)($img['src'] ?? '') : '';
                $alt   = is_array($img) ? (string)($img['alt'] ?? '') : '';

                if (trim($title) === '' || trim($desc) === '' || trim($src) === '') continue;
                if (trim($alt) === '') $alt = $title;
            ?>
                <div class="col-md-6 col-lg-4">
                    <div class="domain-card h-100">
                        <div class="domain-card__img position-relative">

                            <img
                                src="<?= htmlspecialchars($src) ?>"
                                alt="<?= htmlspecialchars($alt) ?>"
                                class="img-fluid w-100 h-100 object-fit-cover"
                                loading="lazy"
                            >

                            <div class="domain-card__overlay">
                                <h3><?= htmlspecialchars($title) ?></h3>
                            </div>
                        </div>

                        <div class="domain-card__body">
                            <?= nl2br(htmlspecialchars($desc)) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- ================= ACCUEIL / MÉTHODE (3 étapes) ================= -->
<section class="ofl-steps-sec">
    <div class="container">
        <div class="ofl-steps-head">
            <div class="ofl-kicker">Notre méthode</div>
            <h2 class="ofl-steps-head__title">Comment se déroule une mission</h2>
            <p class="ofl-steps-head__text">De la première analyse à la remise des livrables, un déroulé clair, adapté à chaque prestation.</p>
        </div>

        <ol class="ofl-steps" data-etapes>
            <li class="ofl-step">
                <div class="ofl-step__dot" aria-hidden="true"><i class="bi bi-search"></i></div>
                <span class="ofl-step__num"></span>
                <h3 class="ofl-step__title">Analyse du besoin</h3>
                <p class="ofl-step__text">Étude du projet, des plans et des données disponibles, puis cadrage de la prestation.</p>
            </li>
            <li class="ofl-step">
                <div class="ofl-step__dot" aria-hidden="true"><i class="bi bi-boxes"></i></div>
                <span class="ofl-step__num"></span>
                <h3 class="ofl-step__title">Études et modélisation</h3>
                <p class="ofl-step__text">Réalisation des études techniques et de la maquette BIM selon la prestation retenue.</p>
            </li>
            <li class="ofl-step">
                <div class="ofl-step__dot" aria-hidden="true"><i class="bi bi-check-lg"></i></div>
                <span class="ofl-step__num"></span>
                <h3 class="ofl-step__title">Livraison</h3>
                <p class="ofl-step__text">Remise des maquettes, plans et documents techniques prévus, dans les formats convenus.</p>
            </li>
        </ol>
    </div>
</section>

<!-- ================= ACCUEIL / LIVRABLES ================= -->
<section class="home-deliverables py-5">
    <div class="container">

        <div class="text-center mx-auto mb-4" style="max-width: 760px;">
            <h2 class="display-6 fw-bold mb-2">Ce que vous recevez</h2>
            <p class="text-muted mb-0">
                Des livrables clairs, exploitables sur chantier et en maîtrise d’œuvre, avec une méthode BIM structurée.
            </p>
        </div>

        <div class="row g-4 align-items-stretch">

           <!-- LEFT: Livrables -->
            <div class="col-lg-6">
                <div class="p-4 border rounded-3 h-100">
                    <h3 class="h5 mb-4 fw-bold text-dark">Livrables</h3>

                    <div class="row g-3">

                        <!-- Maquettes BIM -->
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center bg-dark rounded"
                                        style="width:46px;height:46px;">
                                        <i class="fa fa-cube text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">Maquettes BIM</div>
                                        <ul class="small text-muted mb-0 mt-2 ps-3">
                                            <li>Hydraulique, CVC, lots techniques (Revit)</li>
                                            <li>Disciplinaires & coordination</li>
                                            <li>À partir de plans 2D ou nuages de points</li>
                                            <li>Conformes LOD / LOI</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Familles paramétriques -->
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center bg-dark rounded"
                                        style="width:46px;height:46px;">
                                        <i class="fa fa-tools text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">Familles paramétriques</div>
                                        <ul class="small text-muted mb-0 mt-2 ps-3">
                                            <li>Création sur mesure</li>
                                            <li>Optimisation performance & données</li>
                                            <li>Adaptées chantier & DOE</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gabarits & standards -->
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center bg-dark rounded"
                                        style="width:46px;height:46px;">
                                        <i class="fa fa-layer-group text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">Gabarits & standards</div>
                                        <ul class="small text-muted mb-0 mt-2 ps-3">
                                            <li>Gabarits Revit structurés</li>
                                            <li>Standards graphiques & techniques</li>
                                            <li>Workflows BIM fiables</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Coordination BIM -->
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center bg-dark rounded"
                                        style="width:46px;height:46px;">
                                        <i class="fa fa-project-diagram text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">Coordination BIM</div>
                                        <ul class="small text-muted mb-0 mt-2 ps-3">
                                            <li>Détection d’interférences</li>
                                            <li>Préparation coordination multi-métiers</li>
                                            <li>Support & bonnes pratiques</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DOE numériques -->
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center bg-dark rounded"
                                        style="width:46px;height:46px;">
                                        <i class="fa fa-folder-open text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">DOE numériques</div>
                                        <ul class="small text-muted mb-0 mt-2 ps-3">
                                            <li>DOE BIM exploitables</li>
                                            <li>Données structurées</li>
                                            <li>Prêtes exploitation & maintenance</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Documentation BIM -->
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center bg-dark rounded"
                                        style="width:46px;height:46px;">
                                        <i class="fa fa-book text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">Documentation BIM</div>
                                        <ul class="small text-muted mb-0 mt-2 ps-3">
                                            <li>Guides & bonnes pratiques</li>
                                            <li>Check-lists qualité</li>
                                            <li>Manuels gabarits & familles</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <!-- RIGHT: Outils / standards -->
            <div class="col-lg-6">
                <div class="p-4 border rounded-3 h-100">
                    <h3 class="h5 mb-3">Outils & standards</h3>
                    <p class="text-muted mb-3">
                        Interopérabilité, méthodes et livrables adaptés à votre organisation.
                    </p>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <div class="fw-semibold mb-1">Formats</div>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge text-bg-dark">IFC</span>
                                    <span class="badge text-bg-dark">RVT</span>
                                    <span class="badge text-bg-dark">DWG</span>
                                    <span class="badge text-bg-dark">PDF</span>
                                </div>
                            </div>
                        </div>

                       <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <div class="fw-semibold mb-1">Structuration BIM</div>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge text-bg-dark">Standards</span>
                                    <span class="badge text-bg-dark">Workflows</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <div class="fw-semibold mb-1">Qualité</div>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge text-bg-dark">Nommage</span>
                                    <span class="badge text-bg-dark">Niveaux</span>
                                    <span class="badge text-bg-dark">Phasage</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <div class="fw-semibold mb-1">Documentation</div>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge text-bg-dark">BEP</span>
                                    <span class="badge text-bg-dark">DOE</span>
                                    <span class="badge text-bg-dark">Fiches</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 p-3 rounded-3 bg-light">
                        <div class="d-flex gap-3 align-items-start">
                            <i class="fa fa-shield-alt mt-1"></i>
                            <div>
                                <div class="fw-semibold">Engagement</div>
                                <div class="text-muted small">
                                    Livrables propres, lisibles et exploitables — pas de “maquette brouillon”.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 p-3 rounded-3 bg-light">
                        <div class="d-flex gap-3 align-items-start">
                            <i class="fa fa-sync-alt mt-1"></i>
                            <div>
                                <div class="fw-semibold">Interopérabilité maîtrisée</div>
                                <div class="text-muted small">
                                    Des formats ouverts, des échanges fluides et des workflows compatibles avec vos outils et vos équipes.
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="index.php?page=service"
                    class="btn btn-outline-dark px-4 mt-4">
                        Voir nos services
                    </a>

                </div>
            </div>

        </div>

    </div>
</section>

<!-- ================= ACCUEIL / TEMOIGNAGES ================= -->
<section class="home-testimonials pt-3 pb-5">
    <div class="container">

        <!-- Title -->
        <div class="home-testimonials__head text-center mx-auto mb-4" style="max-width: 760px;">
            <span class="home-testimonials__kicker badge text-bg-light text-uppercase px-3 py-2">
                Témoignages
            </span>

            <h2 class="home-testimonials__title display-6 fw-bold mt-3 mb-2">
                Depuis qu’ils ont testé, ils nous recommandent.
            </h2>

            <p class="home-testimonials__subtitle text-muted mb-0">
                Des clients nous font confiance pour la modélisation BIM, la coordination et la qualité des livrables.
            </p>
        </div>

        <!-- Grid -->
        <div class="row g-4">

            <!-- Testimonial 1 -->
            <div class="col-lg-4">
                <article class="home-testimonials__card h-100 p-4 border rounded-3 bg-white">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img
                            class="home-testimonials__avatar rounded-circle"
                            src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=120&q=70"
                            alt="Portrait client"
                            width="48"
                            height="48"
                            loading="lazy"
                        >
                        <div class="min-w-0">
                            <div class="fw-semibold">Claire</div>
                            <div class="text-muted small">Maîtrise d’œuvre</div>
                        </div>
                    </div>

                    <div class="home-testimonials__stars text-warning mb-3" aria-label="Note 5 sur 5">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>

                    <p class="mb-0">
                        <strong>Livrables très propres et faciles à exploiter.</strong>
                        La coordination a été fluide et les retours rapides. On a gagné du temps sur la synthèse.
                    </p>
                </article>
            </div>

            <!-- Testimonial 2 -->
            <div class="col-lg-4">
                <article class="home-testimonials__card h-100 p-4 border rounded-3 bg-white">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img
                            class="home-testimonials__avatar rounded-circle"
                            src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=120&q=70"
                            alt="Portrait client"
                            width="48"
                            height="48"
                            loading="lazy"
                        >
                        <div class="min-w-0">
                            <div class="fw-semibold">Mehdi</div>
                            <div class="text-muted small">Architecte</div>
                        </div>
                    </div>

                    <div class="home-testimonials__stars text-warning mb-3" aria-label="Note 5 sur 5">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>

                    <p class="mb-0">
                        <strong>Réactivité et méthode.</strong>
                        La maquette est structurée, les échanges sont clairs, et le résultat est vraiment pro.
                    </p>
                </article>
            </div>

            <!-- Testimonial 3 -->
            <div class="col-lg-4">
                <article class="home-testimonials__card h-100 p-4 border rounded-3 bg-white">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img
                            class="home-testimonials__avatar rounded-circle"
                            src="https://images.unsplash.com/photo-1544723795-3fb6469f5b39?auto=format&fit=crop&w=120&q=70"
                            alt="Portrait client"
                            width="48"
                            height="48"
                            loading="lazy"
                        >
                        <div class="min-w-0">
                            <div class="fw-semibold">Sophie</div>
                            <div class="text-muted small">Entreprise (GO)</div>
                        </div>
                    </div>

                    <div class="home-testimonials__stars text-warning mb-3" aria-label="Note 5 sur 5">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>

                    <p class="mb-0">
                        <strong>On évite les erreurs avant chantier.</strong>
                        Les clashes et corrections sont anticipés, ça se ressent direct sur l’organisation.
                    </p>
                </article>
            </div>

        </div>

        <!-- CTA -->
        <div class="text-center mt-4">
            <a href="index.php?page=contact#contact-content"
               class="btn btn-primary btn-lg">
                Contact
            </a>
        </div>

    </div>
</section>

<!-- Comparateur Réel / BIM, ouverture de la démonstration, fil des étapes -->
<script>
(function () {
    const calme = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const observe = 'IntersectionObserver' in window;

    /* ---------- Comparateur ---------- */
    document.querySelectorAll('[data-comparateur]').forEach((stage) => {
        const range = stage.querySelector('input[type="range"]');
        const photo = stage.querySelector('[data-photo]');
        const erreur = stage.querySelector('[data-photo-error]');
        const setPos = (v) => stage.style.setProperty('--pos', v + '%');
        let touche = false;   // l'utilisateur a pris la main : on arrête l'animation d'invitation

        range.addEventListener('input', () => setPos(range.value));

        // Glisser à la souris ou au doigt (même code pour les deux)
        let glisse = false;
        const suivre = (e) => {
            const r = stage.getBoundingClientRect();
            const v = Math.min(100, Math.max(0, ((e.clientX - r.left) / r.width) * 100));
            range.value = v;
            setPos(v);
        };
        stage.addEventListener('pointerdown', (e) => {
            e.preventDefault();   // pas de sélection de texte ni de glisser-déposer
            glisse = true;
            touche = true;
            stage.setPointerCapture(e.pointerId);
            suivre(e);
        });
        stage.addEventListener('pointermove', (e) => { if (glisse) suivre(e); });
        ['pointerup', 'pointercancel'].forEach((t) => stage.addEventListener(t, () => { glisse = false; }));

        // Flèches du clavier : 5 % par appui (Maj + flèche : 20 %)
        range.addEventListener('keydown', (e) => {
            const pas = { ArrowLeft: -5, ArrowDown: -5, ArrowRight: 5, ArrowUp: 5 }[e.key];
            if (!pas) return;
            e.preventDefault();
            touche = true;
            range.value = Math.min(100, Math.max(0, +range.value + pas * (e.shiftKey ? 4 : 1)));
            setPos(range.value);
        });

        // Image absente ou hors ligne : message clair plutôt qu'une image cassée
        const surErreur = (img, message, classe) => {
            if (!img || !message) return;
            const montrer = () => { img.hidden = true; message.hidden = false; if (classe) stage.classList.add(classe); };
            img.addEventListener('error', montrer);
            if (img.complete && img.naturalWidth === 0 && img.getAttribute('src')) montrer();
        };
        surErreur(photo, erreur);
        surErreur(stage.querySelector('[data-maquette]'), stage.querySelector('[data-maquette-error]'), 'is-sans-maquette');

        // Une seule invitation à glisser, quand le comparateur devient visible
        if (calme || !observe) return;


        new IntersectionObserver(([entree], obs) => {
            if (!entree.isIntersecting) return;
            obs.disconnect();

            let debut = null;
            const anime = (t) => {
                if (touche) return;
                debut = debut ?? t;
                const p = Math.min((t - debut) / 1800, 1);
                const v = 50 + Math.sin(p * Math.PI * 2) * 16 * (1 - p * 0.3);
                setPos(v);
                range.value = v;
                if (p < 1) requestAnimationFrame(anime);
                else { setPos(50); range.value = 50; }
            };
            setTimeout(() => requestAnimationFrame(anime), 400);
        }, { threshold: 0.6 }).observe(stage);
    });

    /* ---------- Bouton "Voir la démonstration" : ouvre / ferme la section ---------- */
    const demo = document.querySelector('[data-demo]');
    const toggle = document.querySelector('[data-demo-toggle]');
    if (demo && toggle) {
        const label = toggle.querySelector('[data-demo-label]');
        const ouvrir = (ouvert, defiler) => {
            demo.hidden = !ouvert;
            toggle.setAttribute('aria-expanded', String(ouvert));
            label.textContent = ouvert ? 'Masquer la démonstration' : 'Voir la démonstration';
            if (ouvert && defiler) demo.scrollIntoView({ behavior: calme ? 'auto' : 'smooth', block: 'start' });
            if (!ouvert && defiler) toggle.focus();
        };
        ouvrir(false, false);   // fermée au chargement (visible si JavaScript est désactivé)
        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            ouvrir(demo.hidden, true);
        });
        demo.querySelector('[data-demo-close]').addEventListener('click', () => ouvrir(false, true));
    }

    /* ---------- Étapes : le fil se trace quand la section apparaît ---------- */
    document.querySelectorAll('[data-etapes]').forEach((liste) => {
        if (calme || !observe) {
            liste.style.setProperty('--progress', 1);
            return;
        }
        new IntersectionObserver(([entree], obs) => {
            if (entree.isIntersecting) {
                liste.style.setProperty('--progress', 1);
                obs.disconnect();
            }
        }, { threshold: 0.4 }).observe(liste);
    });
})();
</script>