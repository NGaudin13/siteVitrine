<?php
    // SEO (optionnel)
    $pageTitle = $pageTitle ?? "OFLABIM | Bureau d'Études & Ingénierie";
    $metaDesc  = $metaDesc  ?? "Bureau d'études et ingénierie – solutions techniques, BIM et accompagnement de projets.";
    $canonical = $canonical ?? "http://localhost/siteVitrine/index.php?page=accueil";
?>

<?php require_once(PATH_VIEWS . 'alert.php'); ?>

<!-- ================= ACCUEIL / HEADER CAROUSEL ================= -->
<section class="home-hero page-hero">

    <div id="homeHeroCarousel"
         class="carousel slide carousel-fade"
         data-bs-ride="carousel"
         data-bs-interval="6000">

        <!-- Indicateurs -->
        <div class="carousel-indicators">
            <button type="button"
                    data-bs-target="#homeHeroCarousel"
                    data-bs-slide-to="0"
                    class="active"
                    aria-current="true"
                    aria-label="Slide 1"></button>

            <button type="button"
                    data-bs-target="#homeHeroCarousel"
                    data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
        </div>

        <!-- Slides -->
        <div class="carousel-inner mt-4 ">

            <!-- ===== SLIDE 1 ===== -->
            <div class="carousel-item active home-hero__slide">

                <img
                    src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1920&q=80"
                    class="d-block w-100 home-hero__img"
                    alt="Ingénierie BIM et coordination de projets"
                    loading="lazy"
                >

                <div class="carousel-caption home-hero__overlay">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-12 col-lg-8">

                                <h1 class="display-4 text-white mb-3 home-hero__title">
                                    Bureau d’études & ingénierie BIM
                                </h1>

                                <p class="fs-5 text-white-50 mb-4 home-hero__text">
                                    Des solutions techniques fiables pour des projets structurés,
                                    durables et maîtrisés.
                                </p>

                                <a href="index.php?page=contact#contact-content"
                                   class="btn btn-primary btn-lg">
                                    Contact
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ===== SLIDE 2 ===== -->
            <div class="carousel-item home-hero__slide">

                <img
                    src="https://images.unsplash.com/photo-1565008447742-97f6f38c985c?auto=format&fit=crop&w=1920&q=80"
                    class="d-block w-100 home-hero__img"
                    alt="Études structures et accompagnement technique"
                    loading="lazy"
                >

                <div class="carousel-caption home-hero__overlay">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-12 col-lg-8">

                                <h2 class="display-4 text-white mb-3 home-hero__title">
                                    Structures béton, métal & bois
                                </h2>

                                <p class="fs-5 text-white-50 mb-4 home-hero__text">
                                    Un accompagnement technique rigoureux,
                                    de la conception au chantier.
                                </p>

                                <a href="index.php?page=service"
                                   class="btn btn-primary btn-lg">
                                    Nos services
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Contrôles -->
        <button class="carousel-control-prev"
                type="button"
                data-bs-target="#homeHeroCarousel"
                data-bs-slide="prev"
                aria-label="Précédent">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next"
                type="button"
                data-bs-target="#homeHeroCarousel"
                data-bs-slide="next"
                aria-label="Suivant">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>

</section>

<!-- ================= ACCUEIL / LE BIM ================= -->
<section id="homeBim" class="home-bim py-5">
    <div class="container">

        <div class="row g-5 align-items-stretch">

            <!-- TEXTE -->
            <div class="col-lg-6 d-flex">
                <div class="home-bim__content">

                    <h2 class="display-6 fw-bold mb-4">
                        <?= htmlspecialchars(
                            $sectionsContent['home-bim']['title']
                            ?? 'Le BIM, au cœur de la coordination de vos projets'
                        ) ?>
                    </h2>

                    <p class="text-muted mb-3">
                        <?= nl2br(htmlspecialchars(
                            $sectionsContent['home-bim']['text_1']
                            ?? 'Texte BIM principal'
                        )) ?>
                    </p>

                    <p class="text-muted mb-0">
                        <?= nl2br(htmlspecialchars(
                            $sectionsContent['home-bim']['text_2']
                            ?? 'Texte BIM secondaire'
                        )) ?>
                    </p>

                </div>
            </div>

            <!-- IMAGE -->
            <div class="col-lg-6 d-flex">
                <div class="home-bim__image">
                    <img
                        src="<?= htmlspecialchars(
                            $sectionsContent['home-bim']['image']['src']
                            ?? 'assets/images/accueil_homeBim2.jpg'
                        ) ?>"
                        alt="<?= htmlspecialchars(
                            $sectionsContent['home-bim']['image']['alt']
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
                           href="index.php?page=service#modelisation_bim">
                            <div class="home-services-value__icon bg-dark text-white rounded d-flex align-items-center justify-content-center flex-shrink-0">
                                <i class="bi bi-boxes"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold text-dark">Modélisation BIM de l’existant</div>
                                <div class="text-muted small">Maquettes fiables à partir des données techniques et du terrain</div>
                            </div>
                            <div class="ms-auto home-services-value__pin flex-shrink-0">
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>

                        <!-- Item -->
                        <a class="home-services-value__item d-flex align-items-start text-decoration-none p-3 rounded-3 mb-3"
                           href="index.php?page=service#plan_technique">
                            <div class="home-services-value__icon bg-dark text-white rounded d-flex align-items-center justify-content-center flex-shrink-0">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold text-dark">Plans techniques d’exécution</div>
                                <div class="text-muted small">Documents clairs et exploitables issus des maquettes BIM</div>
                            </div>
                            <div class="ms-auto home-services-value__pin flex-shrink-0">
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>

                        <!-- Item -->
                        <a class="home-services-value__item d-flex align-items-start text-decoration-none p-3 rounded-3 mb-3"
                           href="index.php?page=service#processus_bim">
                            <div class="home-services-value__icon bg-dark text-white rounded d-flex align-items-center justify-content-center flex-shrink-0">
                                <i class="bi bi-wrench-adjustable"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold text-dark">Processus BIM collaboratifs</div>
                                <div class="text-muted small">Structuration des maquettes et organisation des workflows sur ACC</div>
                            </div>
                            <div class="ms-auto home-services-value__pin flex-shrink-0">
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </a>

                        <!-- Item -->
                        <a class="home-services-value__item d-flex align-items-start text-decoration-none p-3 rounded-3"
                           href="index.php?page=service#optimisation_bim">
                            <div class="home-services-value__icon bg-dark text-white rounded d-flex align-items-center justify-content-center flex-shrink-0">
                                <i class="bi bi-tree"></i>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold text-dark">Optimisation BIM & DOE numériques</div>
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
                    <h3 class="h5 mb-3">Livrables</h3>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center bg-dark rounded"
                                         style="width:46px;height:46px;">
                                        <i class="fa fa-cube text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Maquette BIM</div>
                                        <div class="text-muted small">Structurée, propre, prête à coordonner.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center bg-dark rounded"
                                         style="width:46px;height:46px;">
                                        <i class="fa fa-layer-group text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Plans & coupes</div>
                                        <div class="text-muted small">PDF/DWG avec une mise en page pro.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center bg-dark rounded"
                                         style="width:46px;height:46px;">
                                        <i class="fa fa-check-double text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Coordination / clash</div>
                                        <div class="text-muted small">Détection + rapport clair des conflits.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center bg-dark rounded"
                                         style="width:46px;height:46px;">
                                        <i class="fa fa-file-invoice text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Quantités</div>
                                        <div class="text-muted small">Tableaux de quantités pour chiffrage.</div>
                                    </div>
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

