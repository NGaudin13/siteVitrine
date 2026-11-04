<?php
// =========================================================
// FICHIER : siteVitrine/lib/foncBase.php
// Fonctions utilitaires communes à tout le site.
// =========================================================

/* ============================================================
   ALERTES
   ============================================================ */

function choixAlert($message)
{
    $alert = array();
    switch ($message) {
        case 'query':
            $alert['messageAlert'] = ERREUR_QUERY;
            break;
        case 'url_non_valide':
            $alert['messageAlert'] = TEXTE_PAGE_404;
            break;
        default:
            $alert['messageAlert'] = MESSAGE_ERREUR;
    }
    return $alert;
}

/* ============================================================
   PROTECTION CSRF
   ------------------------------------------------------------
   Problème : un site malveillant peut faire soumettre un de nos
   formulaires par le navigateur d'un admin connecté (le cookie
   de session part automatiquement).
   Solution : chaque formulaire contient un jeton secret, connu
   seulement de la session. Sans le bon jeton, la requête est
   refusée.

   Utilisation :
     - dans chaque <form method="post"> : <?= csrf_field() ?>
     - au traitement du POST            : if (!csrf_verify()) { ... }
   ============================================================ */

/** Renvoie le jeton CSRF de la session (le crée si besoin). */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/** Champ caché à placer dans chaque formulaire POST. */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="'
        . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

/** Vérifie le jeton envoyé avec le formulaire. */
function csrf_verify(): bool
{
    $envoye  = $_POST['csrf_token'] ?? '';
    $attendu = $_SESSION['csrf_token'] ?? '';

    // hash_equals : comparaison en temps constant (pas de fuite par le temps de réponse)
    return is_string($envoye) && $attendu !== '' && hash_equals($attendu, $envoye);
}

/* ============================================================
   URL CANONIQUE (SEO)
   ============================================================ */

/** URL absolue d'une page du site, ex : https://domaine.fr/index.php?page=contact */
function url_page(string $page): string
{
    $https  = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    $scheme = $https ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $script = $_SERVER['SCRIPT_NAME'] ?? '/index.php';

    return $scheme . '://' . $host . $script . '?page=' . rawurlencode($page);
}