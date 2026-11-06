<?php
// =========================================================
// FICHIER : siteVitrine/views/confidentialite.php
// Politique de confidentialité (RGPD, articles 13 et 14).
//
// Décrit ce que fait RÉELLEMENT le site :
//   - formulaire de contact (envoi par email, pas de stockage en base)
//   - cookie de session technique uniquement (pas de statistiques)
//   - Google Maps (Contact) et YouTube (Présentation) intégrés directement
// À mettre à jour si le site évolue (ex : ajout de statistiques).
// =========================================================

// Variables fournies par le contrôleur qui inclut cette vue
// (déclarées ici pour VS Code / Intelephense).
/** @var User|null $siteUser */

$e = fn($v): string => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');

$entreprise = $siteUser?->getCompanyName() ?: 'OFLABIM';
$email      = $siteUser?->getEmail() ?: '';
$adresse    = $siteUser?->getAddress() ?: '';
?>
<section class="py-5">
    <div class="container">

        <h1 class="display-6 fw-bold mb-4">Politique de confidentialité</h1>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="p-4 p-lg-5 bg-white border rounded-4 shadow-sm">

                    <h2 class="h4 fw-bold mb-3">1. Responsable du traitement</h2>
                    <p class="text-muted">
                        <?= $e($entreprise) ?><?= $adresse !== '' ? ', ' . $e($adresse) : '' ?>.
                        Contact pour toute question sur vos données :
                        <a href="mailto:<?= $e($email) ?>" class="fw-semibold"><?= $e($email) ?></a>.
                    </p>

                    <hr class="my-4">

                    <h2 class="h4 fw-bold mb-3">2. Données collectées et finalité</h2>
                    <p class="text-muted">
                        Le site ne collecte des données personnelles que via le <strong>formulaire de contact</strong> :
                        nom, adresse email, téléphone (facultatif), type de demande et message.
                    </p>
                    <p class="text-muted">
                        Elles servent <strong>uniquement</strong> à répondre à votre demande (question, devis,
                        prise de rendez-vous). Elles ne sont ni revendues, ni utilisées à des fins publicitaires.
                    </p>

                    <hr class="my-4">

                    <h2 class="h4 fw-bold mb-3">3. Base légale</h2>
                    <p class="text-muted">
                        Le traitement repose sur votre <strong>consentement</strong>, donné en cochant la case
                        du formulaire, et sur les <strong>mesures précontractuelles</strong> prises à votre
                        demande (réponse à une demande de devis).
                    </p>

                    <hr class="my-4">

                    <h2 class="h4 fw-bold mb-3">4. Destinataires</h2>
                    <p class="text-muted">
                        Votre message est transmis par email à <?= $e($entreprise) ?> et n’est accessible
                        qu’aux personnes chargées d’y répondre. Il n’est pas enregistré dans la base de
                        données du site. Les prestataires techniques (hébergeur du site, service d’envoi
                        d’emails) n’y accèdent que pour assurer leur service.
                    </p>

                    <hr class="my-4">

                    <h2 class="h4 fw-bold mb-3">5. Durée de conservation</h2>
                    <p class="text-muted">
                        Les échanges sont conservés <strong>3 ans au maximum après le dernier contact</strong>,
                        sauf si une relation commerciale s’engage (les documents sont alors conservés selon
                        les obligations légales). Les journaux techniques de l’hébergeur (adresse IP) sont
                        conservés au plus 1 an.
                    </p>

                    <hr class="my-4">

                    <h2 class="h4 fw-bold mb-3">6. Vos droits</h2>
                    <p class="text-muted">
                        Vous disposez d’un droit d’accès, de rectification, d’effacement, de limitation,
                        d’opposition et de portabilité de vos données, ainsi que du droit de retirer votre
                        consentement à tout moment. Pour les exercer, écrivez à
                        <a href="mailto:<?= $e($email) ?>" class="fw-semibold"><?= $e($email) ?></a>.
                        Une réponse vous sera apportée dans un délai d’un mois.
                    </p>
                    <p class="text-muted">
                        Si vous estimez que vos droits ne sont pas respectés, vous pouvez adresser une
                        réclamation à la CNIL :
                        <a href="https://www.cnil.fr/fr/plaintes" target="_blank" rel="noopener noreferrer">www.cnil.fr</a>.
                    </p>

                    <hr class="my-4">

                    <h2 class="h4 fw-bold mb-3">7. Cookies et services tiers</h2>
                    <p class="text-muted">
                        Le site lui-même n’utilise <strong>aucun cookie publicitaire ni de mesure d’audience</strong>.
                        Seul un cookie technique de session est déposé : il est nécessaire au fonctionnement
                        du site (sécurité des formulaires, espace d’administration) et ne requiert pas votre
                        consentement.
                    </p>
                    <p class="text-muted mb-0">
                        La page Contact affiche une carte <strong>Google Maps</strong> et la page Présentation
                        une vidéo <strong>YouTube</strong>. Ces services, édités par Google, peuvent déposer
                        leurs propres cookies lors de l’affichage de ces pages ; ils sont régis par
                        <a href="https://policies.google.com/privacy?hl=fr" target="_blank" rel="noopener noreferrer">la politique de confidentialité de Google</a>.
                        Vous pouvez les bloquer à tout moment depuis les réglages de votre navigateur.
                    </p>

                </div>
            </div>

            <div class="col-lg-4">
                <div class="p-4 bg-light border rounded-4 h-100">
                    <h2 class="h5 fw-bold mb-3">En résumé</h2>
                    <ul class="text-muted ps-3 mb-4">
                        <li class="mb-2">Données collectées seulement via le formulaire de contact</li>
                        <li class="mb-2">Utilisées uniquement pour vous répondre</li>
                        <li class="mb-2">Ni revendues, ni publicité</li>
                        <li class="mb-2">Aucun cookie publicitaire déposé par le site</li>
                        <li class="mb-2">Carte Google Maps et vidéo YouTube intégrées</li>
                    </ul>

                    <h2 class="h5 fw-bold mb-3">Voir aussi</h2>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="index.php?page=mentions">Mentions légales</a></li>
                        <li class="mb-2"><a href="index.php?page=conditions">Conditions générales d’utilisation</a></li>
                    </ul>

                    <p class="text-muted small mt-4 mb-0">
                        Dernière mise à jour : <?= date('d/m/Y', filemtime(__FILE__)) ?>
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>