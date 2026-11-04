<?php
// =========================================================
// FICHIER : siteVitrine/views/views_admin/adminCsrf.php
// Affichée quand un formulaire admin arrive sans jeton CSRF valide
// (page restée ouverte trop longtemps, ou tentative d'attaque).
// =========================================================
?>
<div class="border rounded-3 p-4 bg-white">
    <div class="alert alert-warning mb-3">
        <strong>Formulaire expiré.</strong>
        Pour votre sécurité, l’enregistrement n’a pas été effectué.
    </div>

    <p class="text-muted mb-3">
        Rechargez la page puis recommencez votre modification.
    </p>

    <a href="index.php?page=adminDashboard" class="btn btn-primary">
        Retour au tableau de bord
    </a>
</div>