<?php
// SEO admin (optionnel)
$pageTitle = $pageTitle ?? "Admin | OFLABIM";
$metaDesc  = $metaDesc  ?? "Espace d'administration OFLABIM";
$canonical = $canonical ?? "http://localhost/siteVitrine/index.php?page=admin_dashboard";

require_once(PATH_VIEWS . 'header.php');
?>

<section class="admin-shell py-4">
    <div class="container">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
            <div>
                <h1 class="h3 mb-1">Administration</h1>
                <p class="text-muted mb-0">Gérez les contenus du site (version simple).</p>
            </div>

            <a href="index.php?page=accueil" class="btn btn-outline-dark btn-sm">
                Retour au site
            </a>
        </div>

        <!-- Onglets admin -->
        <ul class="nav nav-pills gap-2" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" href="index.php?page=admin_dashboard">
                    Admin général
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="index.php?page=admin_accueil">
                    Admin accueil
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="index.php?page=admin_presentation">
                    Admin presentation
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="index.php?page=admin_services">
                    Admin services
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="index.php?page=admin_contact">
                    Admin contact
                </a>
            </li>
        </ul>

        <div class="border rounded-3 p-4 mt-3 bg-white">
            <h2 class="h5 mb-2">Bienvenue</h2>
            <p class="text-muted mb-0">
                On va brancher ici les formulaires et la BDD ensuite.
                Pour l’instant, c’est juste le squelette propre + navigation admin.
            </p>
        </div>

    </div>
</section>

<?php require_once(PATH_VIEWS . 'footer.php'); ?>
