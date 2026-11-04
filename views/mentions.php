<?php
// =========================================================
// FICHIER : siteVitrine/views/mentions.php
// Mentions légales (obligatoires : loi n° 2004-575 du 21 juin 2004, LCEN).
//
// ⚠️ AVANT LIVRAISON : remplacer chaque "[À COMPLÉTER]" ci-dessous.
// Le nom, l'adresse, l'email et le téléphone viennent déjà de
// l'admin (Paramètres généraux) : rien à saisir ici pour eux.
// =========================================================

// Variables fournies par le contrôleur qui inclut cette vue
// (déclarées ici pour VS Code / Intelephense).
/** @var User|null $siteUser */

$legal = [
    // --- Éditeur du site (l'entreprise cliente)
    'forme_juridique'       => '[À COMPLÉTER]',   // ex : SAS, EURL, Entreprise individuelle
    'capital'               => '[À COMPLÉTER]',   // ex : 1 000 € (laisser '' si entreprise individuelle)
    'siret'                 => '[À COMPLÉTER]',   // 14 chiffres
    'rcs'                   => '[À COMPLÉTER]',   // ex : RCS Lyon 123 456 789 (laisser '' si non inscrit)
    'tva'                   => '[À COMPLÉTER]',   // n° TVA intracommunautaire (laisser '' si non assujetti)
    'directeur_publication' => '[À COMPLÉTER]',   // Prénom NOM du responsable

    // --- Hébergeur (la société qui héberge le site en ligne)
    'hebergeur_nom'         => '[À COMPLÉTER]',   // ex : OVH SAS
    'hebergeur_adresse'     => '[À COMPLÉTER]',   // ex : 2 rue Kellermann, 59100 Roubaix, France
    'hebergeur_contact'     => '[À COMPLÉTER]',   // téléphone ou site web de l'hébergeur

    // --- Réalisation
    'realisation'           => 'NBsolutions – Baptiste BERTRAND & Nicolas GAUDIN',
];

$e = fn($v): string => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');

$entreprise = $siteUser?->getCompanyName() ?: 'OFLABIM';
?>
<section class="py-5">
    <div class="container">

        <h1 class="display-6 fw-bold mb-4">Mentions légales</h1>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="p-4 p-lg-5 bg-white border rounded-4 shadow-sm">

                    <h2 class="h4 fw-bold mb-3">1. Éditeur du site</h2>
                    <ul class="list-unstyled text-muted mb-0">
                        <li class="mb-1"><strong>Raison sociale :</strong> <?= $e($entreprise) ?></li>
                        <li class="mb-1"><strong>Forme juridique :</strong> <?= $e($legal['forme_juridique']) ?></li>
                        <?php if ($legal['capital'] !== ''): ?>
                            <li class="mb-1"><strong>Capital social :</strong> <?= $e($legal['capital']) ?></li>
                        <?php endif; ?>
                        <li class="mb-1"><strong>Siège social :</strong> <?= $e($siteUser?->getAddress() ?? '') ?></li>
                        <li class="mb-1"><strong>SIRET :</strong> <?= $e($legal['siret']) ?></li>
                        <?php if ($legal['rcs'] !== ''): ?>
                            <li class="mb-1"><strong>Immatriculation :</strong> <?= $e($legal['rcs']) ?></li>
                        <?php endif; ?>
                        <?php if ($legal['tva'] !== ''): ?>
                            <li class="mb-1"><strong>TVA intracommunautaire :</strong> <?= $e($legal['tva']) ?></li>
                        <?php endif; ?>
                        <li class="mb-1"><strong>Téléphone :</strong> <?= $e($siteUser?->getPhone() ?? '') ?></li>
                        <li class="mb-1"><strong>Email :</strong> <?= $e($siteUser?->getEmail() ?? '') ?></li>
                        <li class="mb-1"><strong>Directeur de la publication :</strong> <?= $e($legal['directeur_publication']) ?></li>
                    </ul>

                    <hr class="my-4">

                    <h2 class="h4 fw-bold mb-3">2. Hébergement</h2>
                    <ul class="list-unstyled text-muted mb-0">
                        <li class="mb-1"><strong>Hébergeur :</strong> <?= $e($legal['hebergeur_nom']) ?></li>
                        <li class="mb-1"><strong>Adresse :</strong> <?= $e($legal['hebergeur_adresse']) ?></li>
                        <li class="mb-1"><strong>Contact :</strong> <?= $e($legal['hebergeur_contact']) ?></li>
                    </ul>

                    <hr class="my-4">

                    <h2 class="h4 fw-bold mb-3">3. Propriété intellectuelle</h2>
                    <p class="text-muted">
                        L’ensemble des contenus de ce site (textes, images, maquettes, logos, mise en page)
                        est la propriété de <?= $e($entreprise) ?> ou de ses partenaires, sauf mention contraire.
                        Toute reproduction, représentation ou adaptation, totale ou partielle, sans autorisation
                        écrite préalable est interdite.
                    </p>

                    <hr class="my-4">

                    <h2 class="h4 fw-bold mb-3">4. Données personnelles</h2>
                    <p class="text-muted mb-0">
                        Le traitement des données transmises via le formulaire de contact est décrit dans la
                        <a href="index.php?page=confidentialite" class="fw-semibold">politique de confidentialité</a>.
                    </p>

                </div>
            </div>

            <div class="col-lg-4">
                <div class="p-4 bg-light border rounded-4 h-100">
                    <h2 class="h5 fw-bold mb-3">Réalisation du site</h2>
                    <p class="text-muted mb-4"><?= $e($legal['realisation']) ?></p>

                    <h2 class="h5 fw-bold mb-3">Voir aussi</h2>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="index.php?page=conditions">Conditions générales d’utilisation</a></li>
                        <li class="mb-2"><a href="index.php?page=confidentialite">Politique de confidentialité</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</section>