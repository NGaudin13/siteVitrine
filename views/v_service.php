<?php
    // SEO (si ton controller ne les définit pas déjà)
    $pageTitle = $pageTitle ?? "Présentation | OFLABIM";
    $metaDesc  = $metaDesc  ?? "Découvrez OFLABIM : bureau d’études & ingénierie BIM. Coordination, structures et accompagnement de projets.";
    $canonical = $canonical ?? "http://localhost/siteVitrine/index.php?page=service";

    require_once(PATH_VIEWS . 'header.php');
?>

<?php require_once(PATH_VIEWS . 'alert.php'); ?>

<!-- ================= SERVICE / HERO ================= -->
<section
    class="header-service page-hero mt-4 py-4 mb-0"
    style="
        background-image: url('/siteVitrine/assets/images/service_header.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    "
>
    <div class="container py-4">
        <h1 class="display-4 text-white mb-2">Nos services</h1>
        <p class="lead text-white-50 mb-0" style="max-width: 760px;">
            Bureau d’Études & Ingénierie BIM — coordination, modélisation et accompagnement technique de vos projets.
        </p>
    </div>
</section>

<!-- ================= SERVICES / SWIPER ================= -->
<section class="services-swiper-section py-5">
    <div class="container">

        <header class="text-center mx-auto mb-3" style="max-width:760px;">
            <h2 class="display-6 fw-bold mb-2">Nos services</h2>
            <p class="text-muted mb-0">
                BIM, structure et coordination : une méthode claire, des livrables propres.
            </p>
        </header>

        <div class="services-swiper swiper">
            <div class="services-swiper__wrapper swiper-wrapper">

                <!-- Slide 1 -->
                <article class="services-swiper__slide swiper-slide">
                    <div class="services-swiper__card" style="--bg:url('/siteVitrine/assets/images/service_ingenierieBIM.jpg');">
                        <div class="services-swiper__icon"><i class="bi bi-boxes"></i></div>
                        <div class="services-swiper__content">
                            <h3 class="services-swiper__title">Ingénierie BIM</h3>
                            <p class="services-swiper__text">Coordination, maquette, synthèse multi-lots et échanges.</p>
                            <a class="btn btn-primary btn-sm" href="index.php?page=service#bim">En savoir plus</a>
                        </div>
                    </div>
                </article>

                <!-- Slide 2 -->
                <article class="services-swiper__slide swiper-slide">
                    <div class="services-swiper__card" style="--bg:url('https://images.unsplash.com/photo-1565008447742-97f6f38c985c?auto=format&fit=crop&w=1200&q=80');">
                        <div class="services-swiper__icon"><i class="bi bi-building"></i></div>
                        <div class="services-swiper__content">
                            <h3 class="services-swiper__title">Structures béton</h3>
                            <p class="services-swiper__text">Dimensionnement, notes de calcul et plans d’exécution rigoureux.</p>
                            <a class="btn btn-primary btn-sm" href="index.php?page=service#beton">En savoir plus</a>
                        </div>
                    </div>
                </article>

                <!-- Slide 3 -->
                <article class="services-swiper__slide swiper-slide">
                    <div class="services-swiper__card" style="--bg:url('https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=1400&q=70');">
                        <div class="services-swiper__icon"><i class="bi bi-wrench-adjustable"></i></div>
                        <div class="services-swiper__content">
                            <h3 class="services-swiper__title">Structures métal</h3>
                            <p class="services-swiper__text">Conception, assemblages, détails techniques et plans.</p>
                            <a class="btn btn-primary btn-sm" href="index.php?page=service#metal">En savoir plus</a>
                        </div>
                    </div>
                </article>

                <!-- Slide 4 -->
                <article class="services-swiper__slide swiper-slide">
                    <div class="services-swiper__card" style="--bg:url('/siteVitrine/assets/images/service_ossatureBois.jpg');">
                        <div class="services-swiper__icon"><i class="bi bi-tree"></i></div>
                        <div class="services-swiper__content">
                            <h3 class="services-swiper__title">Ossature bois</h3>
                            <p class="services-swiper__text">Études, optimisation, détails et livrables exploitables.</p>
                            <a class="btn btn-primary btn-sm" href="index.php?page=service#bois">En savoir plus</a>
                        </div>
                    </div>
                </article>

            </div>

            <!-- Pagination -->
            <div class="services-swiper__pagination swiper-pagination"></div>

            <!-- Navigation -->
            <div class="services-swiper__btn services-swiper__btn--prev swiper-button-prev" aria-label="Précédent"></div>
            <div class="services-swiper__btn services-swiper__btn--next swiper-button-next" aria-label="Suivant"></div>
        </div>

    </div>
</section>

<!-- ================= SERVICES / DETAILS ================= -->
<section class="services-details pt-3 pb-5">
    <div class="container">

        <header class="text-center mx-auto mb-5" style="max-width: 860px;">
            <h2 class="display-6 fw-bold mb-2">Détails de nos prestations</h2>
            <p class="text-muted mb-0">
                Une vision claire de ce que nous faisons, comment nous le faisons, et le type de résultats attendus.
            </p>
        </header>

        <!-- ===== 1) BIM ===== -->
        <article id="bim" class="services-details__item">
            <div class="row g-4 g-lg-5 align-items-stretch">

                <!-- LEFT -->
                <div class="col-lg-4">
                    <div class="services-details__panel">
                        <p class="services-details__kicker">Service</p>
                        <h3 class="services-details__title">Ingénierie BIM</h3>
                        <p class="services-details__subtitle">
                            Coordination, structuration et qualité des maquettes pour une collaboration fluide.
                        </p>

                        <p class="services-details__text">
                            Nous mettons en place une méthode BIM simple et robuste : maquette structurée,
                            règles de nommage, échanges clairs et livrables exploitables. L’objectif est de réduire les
                            erreurs, limiter les reprises et sécuriser les décisions.
                        </p>

                        <ul class="services-details__list">
                            <li>Structuration IFC/RVT + règles de nommage</li>
                            <li>Clash detection & suivi (BCF / rapports)</li>
                            <li>Synthèse multi-lots + coordination</li>
                            <li>DOE / livrables propres et organisés</li>
                        </ul>

                        <div class="services-details__actions">
                            <a class="btn btn-primary btn-sm" href="index.php?page=contact">Poser une question</a>
                        </div>
                    </div>
                </div>

                <!-- CENTER IMAGE -->
                <div class="col-lg-4">
                    <div class="services-details__media">
                        <img
                            src="/siteVitrine/assets/images/service_ingenierieBIM.jpg"
                            alt="Coordination BIM"
                            loading="lazy"
                        >
                    </div>
                </div>

                <!-- RIGHT PROJECT -->
                <div class="col-lg-4">
                    <aside class="services-details__project">
                        <div class="services-details__project-head">
                            <span class="services-details__badge"><i class="bi bi-check2-circle"></i> Projet réalisé</span>
                            <h4 class="services-details__project-title">Immeuble tertiaire – coordination multi-lots</h4>
                            <p class="services-details__project-text">
                                Mise en place d’un flux BIM, synthèse et coordination entre structure, CVC, plomberie et électricité.
                            </p>
                        </div>

                        <div class="services-details__project-grid">
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Livrables</div>
                                <div class="services-details__stat-value">Rapports clash + BCF</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Format</div>
                                <div class="services-details__stat-value">IFC / RVT / PDF</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Objectif</div>
                                <div class="services-details__stat-value">Réduire les reprises</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Résultat</div>
                                <div class="services-details__stat-value">Coordination fiable</div>
                            </div>
                        </div>

                        <div class="services-details__project-note">
                            <i class="bi bi-lightning-charge"></i>
                            <span>Un process clair = moins d’aller-retours et une maquette exploitable par tous.</span>
                        </div>
                    </aside>
                </div>

            </div>
        </article>

        <!-- ===== 2) BETON ===== -->
        <article id="beton" class="services-details__item">
            <div class="row g-4 g-lg-5 align-items-stretch">

                <div class="col-lg-4">
                    <div class="services-details__panel">
                        <p class="services-details__kicker">Service</p>
                        <h3 class="services-details__title">Structures béton</h3>
                        <p class="services-details__subtitle">
                            Dimensionnement, optimisation et plans d’exécution pour béton armé.
                        </p>

                        <p class="services-details__text">
                            Nous réalisons des études structures orientées chantier : dimensionnement, notes de calcul,
                            plans et détails. L’approche vise la fiabilité et la lisibilité, pour que les équipes exécutent
                            sans ambiguïté.
                        </p>

                        <ul class="services-details__list">
                            <li>Pré-dimensionnement & optimisation</li>
                            <li>Notes de calcul structurées</li>
                            <li>Plans / coupes / détails BA</li>
                            <li>Assistance technique MOE/EXE</li>
                        </ul>

                        <div class="services-details__actions">
                            <a class="btn btn-primary btn-sm" href="index.php?page=contact">Poser une question</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="services-details__media">
                        <img
                            src="https://images.unsplash.com/photo-1565008447742-97f6f38c985c?auto=format&fit=crop&w=1200&q=80"
                            alt="Études structures béton"
                            loading="lazy"
                        >
                    </div>
                </div>

                <div class="col-lg-4">
                    <aside class="services-details__project">
                        <div class="services-details__project-head">
                            <span class="services-details__badge"><i class="bi bi-check2-circle"></i> Projet réalisé</span>
                            <h4 class="services-details__project-title">Bâtiment logements – dalles & voiles</h4>
                            <p class="services-details__project-text">
                                Étude béton armé, optimisation des sections et production de plans d’exécution.
                            </p>
                        </div>

                        <div class="services-details__project-grid">
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Livrables</div>
                                <div class="services-details__stat-value">Notes + plans BA</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Focus</div>
                                <div class="services-details__stat-value">Lisibilité chantier</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Risque</div>
                                <div class="services-details__stat-value">Erreurs évitées</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Résultat</div>
                                <div class="services-details__stat-value">EXE maîtrisée</div>
                            </div>
                        </div>

                        <div class="services-details__project-note">
                            <i class="bi bi-lightning-charge"></i>
                            <span>Des plans clairs = moins de questions en phase travaux.</span>
                        </div>
                    </aside>
                </div>

            </div>
        </article>

        <!-- ===== 3) METAL ===== -->
        <article id="metal" class="services-details__item">
            <div class="row g-4 g-lg-5 align-items-stretch">

                <div class="col-lg-4">
                    <div class="services-details__panel">
                        <p class="services-details__kicker">Service</p>
                        <h3 class="services-details__title">Structures métalliques</h3>
                        <p class="services-details__subtitle">
                            Conception, assemblages, détails et plans pour fabrication / montage.
                        </p>

                        <p class="services-details__text">
                            Nous intervenons sur la conception et la mise au point technique : assemblages, détails,
                            plans et pièces de fabrication. Objectif : un dossier cohérent pour fabriquer et monter sans friction.
                        </p>

                        <ul class="services-details__list">
                            <li>Conception structure & stabilité</li>
                            <li>Détails d’assemblage</li>
                            <li>Plans d’exécution / fabrication</li>
                            <li>Coordination avec l’enveloppe & lots techniques</li>
                        </ul>

                        <div class="services-details__actions">
                            <a class="btn btn-primary btn-sm" href="index.php?page=contact">Poser une question</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="services-details__media">
                        <img
                            src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=1200&q=80"
                            alt="Structures métalliques"
                            loading="lazy"
                        >
                    </div>
                </div>

                <div class="col-lg-4">
                    <aside class="services-details__project">
                        <div class="services-details__project-head">
                            <span class="services-details__badge"><i class="bi bi-check2-circle"></i> Projet réalisé</span>
                            <h4 class="services-details__project-title">Extension – charpente métallique</h4>
                            <p class="services-details__project-text">
                                Dossier EXE avec détails d’assemblage et plans pour fabrication / montage.
                            </p>
                        </div>

                        <div class="services-details__project-grid">
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Livrables</div>
                                <div class="services-details__stat-value">Plans EXE métal</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Focus</div>
                                <div class="services-details__stat-value">Assemblages</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Format</div>
                                <div class="services-details__stat-value">DWG / PDF</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Résultat</div>
                                <div class="services-details__stat-value">Montage fluide</div>
                            </div>
                        </div>

                        <div class="services-details__project-note">
                            <i class="bi bi-lightning-charge"></i>
                            <span>Un bon détail d’assemblage évite 80% des problèmes en atelier.</span>
                        </div>
                    </aside>
                </div>

            </div>
        </article>

        <!-- ===== 4) BOIS ===== -->
        <article id="bois" class="services-details__item">
            <div class="row g-4 g-lg-5 align-items-stretch">

                <div class="col-lg-4">
                    <div class="services-details__panel">
                        <p class="services-details__kicker">Service</p>
                        <h3 class="services-details__title">Ossature bois</h3>
                        <p class="services-details__subtitle">
                            Études et détails techniques orientés préfabrication et chantier.
                        </p>

                        <p class="services-details__text">
                            Nous produisons des dossiers bois clairs : principe structurel, détails, plans et livrables
                            adaptés aux contraintes de fabrication et de montage. L’objectif est un dossier simple à exécuter.
                        </p>

                        <ul class="services-details__list">
                            <li>Principes porteurs & optimisation</li>
                            <li>Détails (liaisons, appuis, reprises)</li>
                            <li>Plans d’exécution</li>
                            <li>Coordination avec lots techniques</li>
                        </ul>

                        <div class="services-details__actions">
                            <a class="btn btn-primary btn-sm" href="index.php?page=contact">Poser une question</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="services-details__media">
                        <img
                            src="/siteVitrine/assets/images/service_ossatureBois.jpg"
                            alt="Ossature bois"
                            loading="lazy"
                        >
                    </div>
                </div>

                <div class="col-lg-4">
                    <aside class="services-details__project">
                        <div class="services-details__project-head">
                            <span class="services-details__badge"><i class="bi bi-check2-circle"></i> Projet réalisé</span>
                            <h4 class="services-details__project-title">Maison individuelle – structure bois</h4>
                            <p class="services-details__project-text">
                                Études et détails techniques, plans d’exécution et coordination avec les lots techniques.
                            </p>
                        </div>

                        <div class="services-details__project-grid">
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Livrables</div>
                                <div class="services-details__stat-value">Plans + détails</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Focus</div>
                                <div class="services-details__stat-value">Préfabrication</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Format</div>
                                <div class="services-details__stat-value">PDF / DWG</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Résultat</div>
                                <div class="services-details__stat-value">Montage rapide</div>
                            </div>
                        </div>

                        <div class="services-details__project-note">
                            <i class="bi bi-lightning-charge"></i>
                            <span>Un dossier bois précis facilite la préfabrication et réduit les ajustements sur site.</span>
                        </div>
                    </aside>
                </div>

            </div>
        </article>

    </div>
</section>

<?php require_once(PATH_VIEWS . 'footer.php'); ?>
