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
                        <!-- items inchangés -->
                    </div>

                </div>
            </div>

            <!-- ===== COL 2 : ÉQUIPE / APPROCHE ===== -->
            <div class="col-lg-4 d-flex">
                <div class="presentation-path__profile h-100 p-4 rounded-4 border bg-white d-flex flex-column text-center">
                    <!-- contenu inchangé -->
                </div>
            </div>

            <!-- ===== COL 3 : COMPÉTENCES & FORMATIONS ===== -->
            <div class="col-lg-4 d-flex">
                <div class="presentation-path__panel h-100 p-4 rounded-4 bg-light">
                    <!-- contenu inchangé -->
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= PRÉSENTATION / PARCOURS VERSION CV ================= -->
<section class="presentation-path py-5">
    <div class="container">
        <!-- structure inchangée -->
    </div>
</section>

<?php require_once(PATH_VIEWS . 'footer.php'); ?>
