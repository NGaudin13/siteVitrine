<?php
    // Variables globales simples (tu pourras les centraliser plus tard)
    $pageTitle = $pageTitle ?? "OFLABIM | Bureau d'Études & Ingénierie";
    $metaDesc  = $metaDesc  ?? "Bureau d'études et ingénierie – solutions techniques, BIM et accompagnement de projets.";
    $canonical = $canonical ?? "http://localhost/siteVitrine/index.php";
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle ?? 'NBsolutions') ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDesc ?? '') ?>">
    <meta name="robots" content="index, follow">
    <meta name="language" content="fr">

    <link rel="canonical" href="<?= htmlspecialchars($canonical ?? '') ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle ?? 'NBsolutions') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($metaDesc ?? '') ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonical ?? '') ?>">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle ?? 'NBsolutions') ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($metaDesc ?? '') ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Teko:wght@400;500;600&display=swap"
        rel="stylesheet"
    >

    <!-- Icons -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
        rel="stylesheet"
    >
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <!-- Bootstrap CSS (CDN) -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Custom service swip -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

</head>

<body>

<!-- ================= TOP BAR ================= -->
<div class="container-fluid bg-dark text-light px-0">
    <div class="row gx-0 d-none d-lg-flex">

        <div class="col-lg-7 px-5 text-start">
           
            <?php if (!empty($siteUser?->getPhone())): ?>
                <div class="h-100 d-inline-flex align-items-center me-4">
                    <i class="fa fa-phone-alt me-2"></i>
                    <a class="text-light" href="tel:<?= preg_replace('/\s+/', '', $siteUser->getPhone()) ?>">
                        <?= htmlspecialchars($siteUser->getPhone()) ?>
                    </a>
                </div>
            <?php endif; ?>


            <div class="h-100 d-inline-flex align-items-center">
            <i class="fa fa-envelope me-2"></i>
            <a
                class="text-light"
                href="mailto:<?= htmlspecialchars($siteUser->getEmail() ?? '') ?>"
            >
                <?= htmlspecialchars($siteUser->getEmail() ?? '') ?>
            </a>
        </div>

        </div>

        <div class="col-lg-5 px-5 text-end">
            <div class="h-100 d-inline-flex align-items-center me-4">
                <a class="text-light me-3" href="index.php?page=conditions">
                    Conditions
                </a>
                <a class="text-light" href="index.php?page=confidentialite">
                    Confidentialité
                </a>
            </div>

            <div class="h-100 d-inline-flex align-items-center">
                <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="#">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>

    </div>
</div>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0">
    <a
        href="index.php?page=accueil"
        class="navbar-brand d-flex align-items-center px-4 px-lg-5"
    >
        <img
            src="assets/images/logo.png"
            alt="OFLABIM"
            class="navbar-logo"
        >
    </a>

    <!-- Mobile: WhatsApp icon + burger (comme le site modèle) -->
    <div class="d-flex align-items-center ms-auto d-lg-none">
        <?php if (!empty($siteUser?->getPhone())): ?>
            <a
                href="tel:<?= preg_replace('/\s+/', '', $siteUser->getPhone()) ?>"
                class="me-3"
                aria-label="Appeler"
                title="Appeler"
            >
                <i class="fa fa-phone-alt fa-2x text-success"></i>
            </a>
        <?php endif; ?>

        <button
            type="button"
            class="navbar-toggler me-2"
            data-bs-toggle="collapse"
            data-bs-target="#navbarCollapse"
            aria-controls="navbarCollapse"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">

            <a href="index.php?page=accueil" class="nav-item nav-link">
                ACCUEIL
            </a>

            <a href="index.php?page=presentation" class="nav-item nav-link">
                PRESENTATION
            </a>

            <div class="nav-item dropdown">
                <a
                    href="index.php?page=expertise"
                    class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                >
                    SERVICES
                </a>

                <div class="dropdown-menu fade-up m-0">
                    <a href="index.php?page=service" class="dropdown-item fw-semibold">
                        Tous nos services
                    </a>

                    <div class="dropdown-divider"></div>

                    <a href="index.php?page=service#modelisation_bim" class="dropdown-item">
                        Modélisation de maquette numérique
                    </a>

                    <a href="index.php?page=service#plan_technique" class="dropdown-item">
                        Production de piéces graphiques
                    </a>

                    <a href="index.php?page=service#processus_bim" class="dropdown-item">
                        Processus BIM collaboratifs
                    </a>

                    <a href="index.php?page=service#optimisation_bim" class="dropdown-item">
                        Optimisation & DOE BIM
                    </a>
                </div>

            </div>

            <a href="index.php?page=contact" class="nav-item nav-link">
                CONTACT
            </a>
            <a href="index.php?page=adminDashboard" class="nav-item nav-link">
                ADMIN
            </a>

        </div>

        <!-- Desktop CTA -->
        <?php if (!empty($siteUser?->getPhone())): ?>
            <a
                href="tel:<?= preg_replace('/\s+/', '', $siteUser->getPhone()) ?>"
                class="btn btn-success btn-sm px-4 py-2 d-none d-lg-inline-flex align-items-center"
                aria-label="Appeler <?= htmlspecialchars($siteUser->getCompanyName() ?? 'nous joindre') ?>"
            >
                <i class="fa fa-phone-alt me-2"></i>
                Nous joindre
            </a>
        <?php endif; ?>

    </div>
</nav>
<main>
