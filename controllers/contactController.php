<?php
// =========================================================
// FICHIER : siteVitrine/controllers/contactController.php
// Formulaire de contact : validation, anti-spam, envoi du mail.
// Inclus par homeController.php (case 'contact').
// =========================================================

// Variables fournies par index.php / homeController.php.
/** @var PDO $pdo */
/** @var User|null $siteUser */

require_once PATH_MODELS . 'PageModel.php';
require_once PATH_MODELS . 'SectionModel.php';
require_once PATH_MODELS . 'ContentBlockModel.php';

// Limites de saisie (protègent contre les abus et les messages géants)
$limites = [
    'name'    => 100,
    'email'   => 190,
    'phone'   => 20,
    'message' => 5000,
];

// Adresse qui reçoit les messages (modifiable dans l'admin)
$to = $siteUser?->getEmail() ?: 'contact@oflabim.fr';

$pageModel         = new PageModel($pdo);
$sectionModel      = new SectionModel($pdo);
$contentBlockModel = new ContentBlockModel($pdo);

$errors = [];

// Message de succès transmis par la redirection (voir étape 3.4)
$flashSuccess = $_SESSION['contactFlash'] ?? null;
unset($_SESSION['contactFlash']);

// Identifiant court pour suivre une requête dans les logs.
// RGPD : on ne journalise JAMAIS le contenu saisi par le visiteur.
$reqId = date('Ymd_His') . '_' . bin2hex(random_bytes(3));

// ============================================================
// 1) Sujets du formulaire (gérés dans l'admin)
// ============================================================
$sectionsContent = [];
$subjectLabels   = [];   // value technique => libellé affiché

$contactPage = $pageModel->findBySlug('contact');

if ($contactPage) {

    $sections = $sectionModel->findByPageId((int) $contactPage->getId(), true);

    foreach ($sections as $section) {

        $slug   = (string) $section->getSlug();
        $blocks = $contentBlockModel->findBySectionIdIndexedBySlot((int) $section->getId(), true);

        foreach ($blocks as $slot => $block) {

            if (strpos($slot, 'subject_') === 0) {
                $sectionsContent[$slug][$slot] = [
                    'text'        => (string) ($block->getText() ?? ''),
                    'order_index' => (int) ($block->getOrderIndex() ?? 0),
                ];

                if ($slug === 'contact-nature-demande') {
                    $subjectLabels[substr($slot, 8)] = (string) ($block->getText() ?? '');
                }
                continue;
            }

            $sectionsContent[$slug][$slot] = (string) ($block->getText() ?? '');
        }
    }
}

// ============================================================
// 2) Valeurs du formulaire (ré-affichées en cas d'erreur)
// ============================================================
$old = [
    'name'    => '',
    'email'   => '',
    'phone'   => '',
    'subject' => '',
    'message' => '',
    'rgpd'    => false,
];

// ============================================================
// 3) Traitement de l'envoi
// ============================================================
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {

    $old['name']    = trim((string) ($_POST['name'] ?? ''));
    $old['email']   = trim((string) ($_POST['email'] ?? ''));
    $old['phone']   = trim((string) ($_POST['phone'] ?? ''));
    $old['subject'] = trim((string) ($_POST['subject'] ?? ''));
    $old['message'] = trim((string) ($_POST['message'] ?? ''));
    $old['rgpd']    = isset($_POST['rgpd']);

    // --------------------------------------------------------
    // 3.1) Anti-spam "pot de miel" (honeypot)
    // Champ invisible pour un humain : seuls les robots le remplissent.
    // On fait comme si tout allait bien, sans rien envoyer.
    // --------------------------------------------------------
    if (trim((string) ($_POST['website'] ?? '')) !== '') {
        error_log("[$reqId] CONTACT: envoi bloqué (anti-spam)");
        $_SESSION['contactFlash'] = "Message envoyé ✅ Nous vous répondrons sous 24–48h ouvrées.";
        header('Location: index.php?page=contact#contact-form');
        exit;
    }

    // --------------------------------------------------------
    // 3.2) Validation
    // --------------------------------------------------------

    // CSRF : le formulaire doit venir de notre site
    if (!csrf_verify()) {
        $errors['global'] = "Le formulaire a expiré. Merci de vérifier vos informations et de le renvoyer.";
    }

    if ($old['name'] === '') {
        $errors['name'] = 'Le nom est obligatoire.';
    } elseif (preg_match('/[\r\n]/', $old['name'])) {
        // SÉCURITÉ : un retour à la ligne dans le nom permettrait
        // d'ajouter des en-têtes au mail (Bcc: ...) => injection.
        $errors['name'] = 'Le nom contient des caractères non autorisés.';
    } elseif (mb_strlen($old['name']) > $limites['name']) {
        $errors['name'] = "Le nom est trop long ({$limites['name']} caractères maximum).";
    }

    if ($old['email'] === '' || !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Adresse email invalide.';
    } elseif (mb_strlen($old['email']) > $limites['email']) {
        $errors['email'] = 'Adresse email trop longue.';
    }

    if ($old['phone'] !== '' && !preg_match('/^\+?[0-9\s\-().]{6,20}$/', $old['phone'])) {
        $errors['phone'] = 'Numéro de téléphone invalide.';
    }

    if ($old['subject'] === '' || !array_key_exists($old['subject'], $subjectLabels)) {
        $errors['subject'] = 'Veuillez choisir un type de demande.';
    }

    if ($old['message'] === '') {
        $errors['message'] = 'Le message est obligatoire.';
    } elseif (mb_strlen($old['message']) > $limites['message']) {
        $errors['message'] = "Le message est trop long ({$limites['message']} caractères maximum).";
    }

    if (!$old['rgpd']) {
        $errors['rgpd'] = 'Vous devez accepter l’utilisation de vos informations pour être recontacté.';
    }

    // --------------------------------------------------------
    // 3.3) Envoi du mail
    // --------------------------------------------------------
    if (empty($errors)) {

        $subjectLabel = $subjectLabels[$old['subject']];

        // Les en-têtes de mail n'acceptent que l'ASCII :
        // mb_encode_mimeheader encode proprement les accents.
        $mailSubject = mb_encode_mimeheader("[OFLABIM] Nouveau message - {$subjectLabel}", 'UTF-8');
        $replyName   = mb_encode_mimeheader($old['name'], 'UTF-8');

        $body  = "Nouveau message depuis le site OFLABIM\n\n";
        $body .= "Nom : {$old['name']}\n";
        $body .= "Email : {$old['email']}\n";
        $body .= "Téléphone : " . ($old['phone'] !== '' ? $old['phone'] : 'Non renseigné') . "\n";
        $body .= "Type de demande : {$subjectLabel}\n\n";
        $body .= "Message :\n{$old['message']}\n\n";
        $body .= "—\nEnvoyé depuis la page Contact.\n";

        $headers = [
            'MIME-Version: 1.0',
            'Content-Type: text/plain; charset=UTF-8',
            'Content-Transfer-Encoding: 8bit',
            'From: OFLABIM <no-reply@oflabim.fr>',
            "Reply-To: {$replyName} <{$old['email']}>",
        ];

        $ok = @mail($to, $mailSubject, $body, implode("\r\n", $headers));

        if ($ok) {
            error_log("[$reqId] CONTACT: message envoyé (type={$old['subject']})");

            // 3.4) Redirection après succès (motif Post/Redirect/Get) :
            // un F5 ne renverra pas le message une deuxième fois.
            $_SESSION['contactFlash'] = "Message envoyé ✅ Nous vous répondrons sous 24–48h ouvrées.";
            header('Location: index.php?page=contact#contact-form');
            exit;
        }

        // Détail technique pour le développeur uniquement (sans données perso)
        $lastError = error_get_last();
        error_log("[$reqId] CONTACT: échec de mail() - " . ($lastError['message'] ?? 'raison inconnue'));

        // Message clair pour le visiteur
        $errors['global'] = "Votre message n’a pas pu être envoyé pour le moment. "
                          . "Merci de réessayer plus tard ou de nous appeler.";
    }
}

// La vue views/contact.php est incluse ensuite par homeController.php.