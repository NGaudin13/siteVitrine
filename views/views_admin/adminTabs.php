<section class="admin-shell py-4">
    <div class="container">

        <div class="admin-header d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
            <div>
                <h1 class="h3 mb-1">Administration</h1>
                <p class="text-muted mb-0">Gérez les contenus du site (version simple).</p>
            </div>

            <a href="index.php?page=accueil" class="btn btn-outline-dark btn-sm">
                Retour au site
            </a>
        </div>

        <!-- Onglets admin -->
        <ul class="nav nav-pills gap-2 mb-3" role="tablist">

            <li class="nav-item">
                <a class="nav-link <?= ($activeTab ?? '') === 'dashboard' ? 'active' : '' ?>"
                   href="index.php?page=adminDashboard">
                    Admin général
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= ($activeTab ?? '') === 'accueil' ? 'active' : '' ?>"
                   href="index.php?page=adminAccueil">
                    Admin accueil
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= ($activeTab ?? '') === 'presentation' ? 'active' : '' ?>"
                   href="index.php?page=adminPresentation">
                    Admin présentation
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= ($activeTab ?? '') === 'services' ? 'active' : '' ?>"
                   href="index.php?page=adminServices">
                    Admin services
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= ($activeTab ?? '') === 'contact' ? 'active' : '' ?>"
                   href="index.php?page=adminContact">
                    Admin contact
                </a>
            </li>

        </ul>
