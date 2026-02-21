<?php
    // SEO (si ton controller ne les définit pas déjà)
    $pageTitle = $pageTitle ?? "Présentation | OFLABIM";
    $metaDesc  = $metaDesc  ?? "Découvrez OFLABIM : bureau d’études & ingénierie BIM. Coordination, structures et accompagnement de projets.";
    $canonical = $canonical ?? "http://localhost/siteVitrine/index.php?page=service";
?>

<?php require_once(PATH_VIEWS . 'alert.php'); ?>

<!-- ================= SERVICE / HERO ================= -->
<section
    class="header-service page-hero mt-4 py-4 mb-0"
    style="
        background-image: url('/siteVitrine/assets/images/stationEpuration.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    "
>
    <div class="container py-4">

        <h1 class="display-4 text-white mb-2">
            Nos services
        </h1>

        <h2 class="h3 text-white mb-3">
            De la donnée à la décision
        </h2>

        <p class="lead text-white-50 mb-0" style="max-width: 760px;">
            Modélisation BIM, production de plans techniques, structuration des processus collaboratifs
            et préparation de DOE numériques pour des projets fiables et maîtrisés.
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
                        <div class="services-swiper__card" style="--bg:url('/siteVitrine/assets/images/service1.jpg');">
                            <div class="services-swiper__icon"><i class="bi bi-boxes"></i></div>
                            <div class="services-swiper__content">
                                <h3 class="services-swiper__title">Modélisation de maquette numérique</h3>
                                <p class="services-swiper__text">
                                    Maquettes fiables issues des données techniques et de l’existant.
                                </p>
                                <a class="btn btn-primary btn-sm" href="index.php?page=service#modelisation_bim">
                                    En savoir plus
                                </a>
                            </div>
                        </div>
                    </article>

                    <!-- Slide 2 -->
                    <article class="services-swiper__slide swiper-slide">
                        <div class="services-swiper__card" style="--bg:url('/siteVitrine/assets/images/service2.jpg');">
                            <div class="services-swiper__icon"><i class="bi bi-building"></i></div>
                            <div class="services-swiper__content">
                                <h3 class="services-swiper__title">Production de piéces graphiques</h3>
                                <p class="services-swiper__text">
                                    Documents clairs et exploitables pour les phases PRO et EXE.
                                </p>
                                <a class="btn btn-primary btn-sm" href="index.php?page=service#plan_technique">
                                    En savoir plus
                                </a>
                            </div>
                        </div>
                    </article>

                    <!-- Slide 3 -->
                    <article class="services-swiper__slide swiper-slide">
                        <div class="services-swiper__card" style="--bg:url('/siteVitrine/assets/images/service3.png');">
                            <div class="services-swiper__icon"><i class="bi bi-wrench-adjustable"></i></div>
                            <div class="services-swiper__content">
                                <h3 class="services-swiper__title">Processus BIM collaboratifs</h3>
                                <p class="services-swiper__text">
                                    Structuration des maquettes et organisation des workflows.
                                </p>
                                <a class="btn btn-primary btn-sm" href="index.php?page=service#processus_bim">
                                    En savoir plus
                                </a>
                            </div>
                        </div>
                    </article>

                    <!-- Slide 4 -->
                    <article class="services-swiper__slide swiper-slide">
                        <div class="services-swiper__card" style="--bg:url('/siteVitrine/assets/images/service4.webp');">
                            <div class="services-swiper__icon"><i class="bi bi-gear"></i></div>
                            <div class="services-swiper__content">
                                <h3 class="services-swiper__title">Optimisation & DOE BIM</h3>
                                <p class="services-swiper__text">
                                    Automatisation, fiabilisation des données et IFC conformes.
                                </p>
                                <a class="btn btn-primary btn-sm" href="index.php?page=service#optimisation_bim">
                                    En savoir plus
                                </a>
                            </div>
                        </div>
                    </article>

                </div>
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

        <!-- ===== 1) MODELISATION BIM ===== -->
        <article id="modelisation_bim" class="services-details__item">
            <div class="row g-4 g-lg-5 align-items-stretch">

                <!-- LEFT -->
                <div class="col-lg-4">
                    <div class="services-details__panel">
                        <p class="services-details__kicker">Service</p>
                        <h3 class="services-details__title">Modélisation de maquette numérique</h3>
                        <p class="services-details__subtitle">
                            Maquettes fiables à partir de l’existant et des données techniques.
                        </p>

                        <p class="services-details__text">
                            Nous réalisons des maquettes numériques BIM sous Revit à partir de documents techniques existants :
                            dossiers d’études, PID, schémas de principe, notes de calcul, plans d’exécution et documents fournisseurs.
                        </p>

                        <p class="services-details__text">
                            Nous modélisons également l’existant à partir de nuages de points afin de restituer fidèlement les installations
                            en place et de sécuriser les projets de réhabilitation ou d’extension.
                        </p>

                        <p class="services-details__text">
                            Les maquettes sont développées avec un niveau de détail adapté aux phases AVP, PRO et EXE,
                            en cohérence avec le cycle de vie du projet, pour les secteurs de l’eau, de l’air, des déchets,
                            du CVC, de l’industrie et du pharmaceutique.
                        </p>

                        <ul class="services-details__list">
                            <li>Revit : modélisation à partir des données techniques</li>
                            <li>Nuage de points : restitution de l’existant</li>
                            <li>Niveau de détail adapté (AVP / PRO / EXE)</li>
                            <li>Secteurs techniques : eau, air, déchets, CVC, industrie…</li>
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
                            src="/siteVitrine/assets/images/service1.jpg"
                            alt="Modélisation BIM à partir de l’existant"
                            loading="lazy"
                        >
                    </div>
                </div>

                <!-- RIGHT PROJECT -->
                <div class="col-lg-4">
                    <aside class="services-details__project">
                        <div class="services-details__project-head">
                            <span class="services-details__badge"><i class="bi bi-check2-circle"></i> Exemple de projet</span>
                            <h4 class="services-details__project-title">Site industriel – modélisation de l’existant</h4>

                            <p class="services-details__project-text">
                                Reconstitution d’installations techniques à partir de documents d’études et d’un nuage de points,
                                afin de disposer d’une base fiable pour une réhabilitation.
                            </p>

                            <p class="services-details__project-text">
                                La maquette est structurée pour être exploitable en phase études comme en phase exécution, avec un niveau
                                de détail ajusté (AVP / PRO / EXE) et des vues adaptées aux besoins du projet.
                            </p>
                        </div>

                        <div class="services-details__project-grid">
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Livrables</div>
                                <div class="services-details__stat-value">Maquette Revit</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Données</div>
                                <div class="services-details__stat-value">Plans + nuage de points</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Phases</div>
                                <div class="services-details__stat-value">AVP / PRO / EXE</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Résultat</div>
                                <div class="services-details__stat-value">Existant fiabilisé</div>
                            </div>
                        </div>

                        <div class="services-details__project-note">
                            <i class="bi bi-lightning-charge"></i>
                            <span>Une base “existant” fiable sécurise les décisions et limite les surprises en phase travaux.</span>
                        </div>
                    </aside>
                </div>

            </div>
        </article>

        <!-- ===== 2) PLANS TECHNIQUES ===== -->
        <article id="plan_technique" class="services-details__item">
            <div class="row g-4 g-lg-5 align-items-stretch">

                <!-- LEFT -->
                <div class="col-lg-4">
                    <div class="services-details__panel">
                        <p class="services-details__kicker">Service</p>
                        <h3 class="services-details__title">Production de piéces graphiques</h3>
                        <p class="services-details__subtitle">
                            Pièces graphiques adaptées aux phases PRO et EXE.
                        </p>

                        <p class="services-details__text">
                            À partir des maquettes numériques, nous produisons des pièces graphiques adaptées aux besoins du projet :
                            plans guides équipements et génie civil, plans d’implantation, plans de manutention,
                            schémas fonctionnels et documents dédiés à la consultation.
                        </p>

                        <p class="services-details__text">
                            Ces livrables sont principalement destinés aux phases PRO et EXE,
                            avec une attention particulière portée à la lisibilité, à la cohérence technique
                            et à leur utilisation sur le terrain.
                        </p>

                        <ul class="services-details__list">
                            <li>Plans guides équipements / génie civil</li>
                            <li>Plans d’implantation et de manutention</li>
                            <li>Schémas fonctionnels</li>
                            <li>Documents de consultation</li>
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
                            src="/siteVitrine/assets/images/service2.jpg"
                            alt="Plans techniques"
                            loading="lazy"
                        >
                    </div>
                </div>

                <!-- RIGHT PROJECT -->
                <div class="col-lg-4">
                    <aside class="services-details__project">
                        <div class="services-details__project-head">
                            <span class="services-details__badge"><i class="bi bi-check2-circle"></i> Exemple de projet</span>
                            <h4 class="services-details__project-title">Local technique – plans PRO / EXE</h4>

                            <p class="services-details__project-text">
                                Production de plans d’implantation, schémas et documents de consultation à partir d’une maquette BIM.
                                Les plans sont préparés pour une lecture rapide et une utilisation directe en phase travaux.
                            </p>

                            <p class="services-details__project-text">
                                L’objectif est de limiter les ambiguïtés sur chantier : repérages cohérents, informations utiles au bon endroit,
                                et documents structurés pour faciliter validations et exécution.
                            </p>
                        </div>

                        <div class="services-details__project-grid">
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Livrables</div>
                                <div class="services-details__stat-value">Plans + schémas</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Phases</div>
                                <div class="services-details__stat-value">PRO / EXE</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Focus</div>
                                <div class="services-details__stat-value">Lisibilité terrain</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Résultat</div>
                                <div class="services-details__stat-value">Exécution fluide</div>
                            </div>
                        </div>

                        <div class="services-details__project-note">
                            <i class="bi bi-lightning-charge"></i>
                            <span>Des plans clairs = moins d’allers-retours et une exécution plus sereine.</span>
                        </div>
                    </aside>
                </div>

            </div>
        </article>

        <!-- ===== 3) PROCESSUS BIM ===== -->
        <article id="processus_bim" class="services-details__item">
            <div class="row g-4 g-lg-5 align-items-stretch">

                <!-- LEFT -->
                <div class="col-lg-4">
                    <div class="services-details__panel">
                        <p class="services-details__kicker">Service</p>
                        <h3 class="services-details__title">Processus BIM collaboratifs</h3>
                        <p class="services-details__subtitle">
                            Structuration des maquettes et organisation des workflows sur ACC.
                        </p>

                        <p class="services-details__text">
                            Nous accompagnons la mise en place et l’organisation des processus BIM sur des plateformes collaboratives
                            telles qu’Autodesk Construction Cloud (ACC).
                        </p>

                        <p class="services-details__text">
                            Cette prestation inclut la structuration des maquettes Revit, la gestion du CDE, l’organisation des données
                            et la mise en place de workflows adaptés, afin de garantir une continuité numérique fiable sur l’ensemble
                            du cycle de vie du projet.
                        </p>

                        <ul class="services-details__list">
                            <li>Structuration des maquettes Revit</li>
                            <li>Gestion du CDE (dossiers, versions, diffusion)</li>
                            <li>Organisation des données projet</li>
                            <li>Workflows : validations et suivi</li>
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
                            src="/siteVitrine/assets/images/service3.png"
                            alt="Processus BIM collaboratifs"
                            loading="lazy"
                        >
                    </div>
                </div>

                <!-- RIGHT PROJECT -->
                <div class="col-lg-4">
                    <aside class="services-details__project">
                        <div class="services-details__project-head">
                            <span class="services-details__badge"><i class="bi bi-check2-circle"></i> Exemple de projet</span>
                            <h4 class="services-details__project-title">Projet multi-intervenants – organisation ACC</h4>

                            <p class="services-details__project-text">
                                Mise en place d’un environnement collaboratif ACC : structure du CDE, règles de dépôt, conventions de nommage
                                et circuits de validation simples pour fiabiliser les échanges.
                            </p>

                            <p class="services-details__project-text">
                                L’objectif est d’assurer une continuité numérique : données accessibles, versions maîtrisées,
                                et workflows cohérents tout au long du projet.
                            </p>
                        </div>

                        <div class="services-details__project-grid">
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Plateforme</div>
                                <div class="services-details__stat-value">Autodesk ACC</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">CDE</div>
                                <div class="services-details__stat-value">Dossiers + versions</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Workflows</div>
                                <div class="services-details__stat-value">Validation simple</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Résultat</div>
                                <div class="services-details__stat-value">Continuité fiable</div>
                            </div>
                        </div>

                        <div class="services-details__project-note">
                            <i class="bi bi-lightning-charge"></i>
                            <span>Un CDE clair = des fichiers maîtrisés, des validations rapides, et moins d’erreurs.</span>
                        </div>
                    </aside>
                </div>

            </div>
        </article>

        <!-- ===== 4) OPTIMISATION / DOE ===== -->
        <article id="optimisation_bim" class="services-details__item">
            <div class="row g-4 g-lg-5 align-items-stretch">

                <!-- LEFT -->
                <div class="col-lg-4">
                    <div class="services-details__panel">
                        <p class="services-details__kicker">Service</p>
                        <h3 class="services-details__title">Optimisation BIM & préparation DOE numérique</h3>
                        <p class="services-details__subtitle">
                            Automatisation, fiabilisation des données et IFC conformes.
                        </p>

                        <p class="services-details__text">
                            Nous développons des familles paramétriques Revit adaptées aux installations techniques,
                            optimisons les gabarits de travail et mettons en place des scripts Dynamo pour automatiser les tâches répétitives,
                            fiabiliser les données et améliorer la productivité des équipes BIM.
                        </p>

                        <p class="services-details__text">
                            En phase DOE, nous réalisons l’allègement, le nettoyage et la structuration des maquettes numériques afin de maîtriser
                            le poids des fichiers et de produire des IFC conformes aux exigences contractuelles, garantissant leur exploitabilité
                            et la traçabilité des données pour l’exploitation et la maintenance.
                        </p>

                        <ul class="services-details__list">
                            <li>Familles paramétriques Revit</li>
                            <li>Optimisation des gabarits</li>
                            <li>Scripts Dynamo (automatisation)</li>
                            <li>Nettoyage / allègement / IFC DOE</li>
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
                            src="/siteVitrine/assets/images/service4.webp"
                            alt="Optimisation BIM et DOE numériques"
                            loading="lazy"
                        >
                    </div>
                </div>

                <!-- RIGHT PROJECT -->
                <div class="col-lg-4">
                    <aside class="services-details__project">
                        <div class="services-details__project-head">
                            <span class="services-details__badge"><i class="bi bi-check2-circle"></i> Exemple de projet</span>
                            <h4 class="services-details__project-title">DOE numérique – maquette structurée et IFC</h4>

                            <p class="services-details__project-text">
                                Optimisation d’une maquette : nettoyage des données, allègement des fichiers et préparation d’un export IFC
                                conforme aux exigences contractuelles.
                            </p>

                            <p class="services-details__project-text">
                                Mise en place d’automatisations Dynamo pour fiabiliser les informations, limiter les actions manuelles,
                                et garantir une maquette exploitable pour l’exploitation et la maintenance.
                            </p>
                        </div>

                        <div class="services-details__project-grid">
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Automatisation</div>
                                <div class="services-details__stat-value">Dynamo</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Livrables</div>
                                <div class="services-details__stat-value">IFC DOE</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Objectif</div>
                                <div class="services-details__stat-value">Poids maîtrisé</div>
                            </div>
                            <div class="services-details__stat">
                                <div class="services-details__stat-label">Résultat</div>
                                <div class="services-details__stat-value">Exploitable</div>
                            </div>
                        </div>

                        <div class="services-details__project-note">
                            <i class="bi bi-lightning-charge"></i>
                            <span>Un DOE bien préparé facilite la reprise et la traçabilité des données dans le temps.</span>
                        </div>
                    </aside>
                </div>

            </div>
        </article>

    </div>
</section>
