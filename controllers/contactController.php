<?php
// controllers/ContactController.php

require_once PATH_MODELS . 'PageModel.php';
require_once PATH_MODELS . 'SectionModel.php';
require_once PATH_MODELS . 'ContentBlockModel.php';

// Email de réception (client) => dynamique
$to = $siteUser?->getEmail() ?: 'contact@oflabim.fr';

// Models (pour construire $sectionsContent)
$pageModel         = new PageModel($pdo);
$sectionModel      = new SectionModel($pdo);
$contentBlockModel = new ContentBlockModel($pdo);

// Variables pour la vue
$errors = [];
$flashSuccess = null;

// ID pour suivre une requête dans les logs
$reqId = date('Ymd_His') . '_' . bin2hex(random_bytes(3));
error_log("[$reqId] CONTACT: controller loaded | method=" . ($_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN'));

// ============================================================
// 1) Construire sectionsContent (pour le select dynamique)
// ============================================================
$sectionsContent = [];

$page = $pageModel->findBySlug('contact');

if ($page) {

    $sections = $sectionModel->findByPageId((int)$page->getId(), true);

    foreach ($sections as $section) {

        $slug = (string)$section->getSlug();
        $sid  = (int)$section->getId();

        $blocks = $contentBlockModel->findBySectionIdIndexedBySlot($sid, true);

        foreach ($blocks as $slot => $block) {

            // Cas "subjects" (options du select) : slots subject_*
            if (strpos($slot, 'subject_') === 0) {
                $sectionsContent[$slug][$slot] = [
                    'text'        => (string)($block->getText() ?? ''),
                    'order_index' => (int)($block->getOrderIndex() ?? 0),
                ];
                continue;
            }

            // Contenu standard (si tu en as besoin plus tard)
            $sectionsContent[$slug][$slot] = (string)($block->getText() ?? '');
        }
    }
}

// Préparer la liste des valeurs autorisées pour la validation
$allowedSubjects = [];
$rawSubjects = $sectionsContent['contact-nature-demande'] ?? [];

foreach ($rawSubjects as $slot => $val) {
    if (strpos($slot, 'subject_') !== 0) continue;
    $allowedSubjects[] = substr($slot, 8); // après "subject_"
}

error_log("[$reqId] CONTACT: allowedSubjects=" . implode(',', $allowedSubjects));

// ============================================================
// 2) Pré-remplissage (UX)
// ============================================================
$old = [
    'name'    => '',
    'email'   => '',
    'phone'   => '',
    'subject' => '',
    'message' => '',
];

// ============================================================
// 3) POST
// ============================================================
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {

    error_log("[$reqId] CONTACT: POST received");
    error_log("[$reqId] CONTACT: POST payload=" . print_r($_POST, true));

    // 3.1) Récup
    $old['name']    = trim($_POST['name'] ?? '');
    $old['email']   = trim($_POST['email'] ?? '');
    $old['phone']   = trim($_POST['phone'] ?? '');
    $old['subject'] = trim($_POST['subject'] ?? '');
    $old['message'] = trim($_POST['message'] ?? '');
    $rgpdAccepted   = isset($_POST['rgpd']);

    error_log("[$reqId] CONTACT: parsed fields name={$old['name']} email={$old['email']} subject={$old['subject']} rgpd=" . ($rgpdAccepted ? '1' : '0'));

    // 3.2) Validation
    if ($old['name'] === '') {
        $errors['name'] = 'Le nom est obligatoire.';
    }

    if ($old['email'] === '' || !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email invalide.';
    }

    // ✅ validation stricte : doit être dans la liste DB
    if ($old['subject'] === '' || (!empty($allowedSubjects) && !in_array($old['subject'], $allowedSubjects, true))) {
        $errors['subject'] = 'Veuillez choisir un type de demande valide.';
    }

    if ($old['message'] === '') {
        $errors['message'] = 'Le message est obligatoire.';
    }

    if (!$rgpdAccepted) {
        $errors['rgpd'] = 'Vous devez accepter la mention RGPD.';
    }

    if (!empty($errors)) {
        error_log("[$reqId] CONTACT: validation errors=" . print_r($errors, true));
    }

    // 3.3) Envoi mail
    if (empty($errors)) {

        $safeName    = htmlspecialchars($old['name'], ENT_QUOTES, 'UTF-8');
        $safeEmail   = htmlspecialchars($old['email'], ENT_QUOTES, 'UTF-8');
        $safeSubject = htmlspecialchars($old['subject'], ENT_QUOTES, 'UTF-8');

        // Optionnel : afficher le label plutôt que la value
        $subjectLabel = $old['subject'];
        foreach ($rawSubjects as $slot => $val) {
            if (strpos($slot, 'subject_') !== 0) continue;
            if (substr($slot, 8) === $old['subject']) {
                $subjectLabel = is_array($val) ? ($val['text'] ?? $old['subject']) : $old['subject'];
                break;
            }
        }

        $mailSubject = "[OFLABIM] Nouveau message - " . $subjectLabel;

        $body  = "Nouveau message depuis le site OFLABIM\n\n";
        $body .= "Nom : {$old['name']}\n";
        $body .= "Email : {$old['email']}\n";
        $body .= "Téléphone : " . ($old['phone'] ?: 'Non renseigné') . "\n";
        $body .= "Type de demande : {$subjectLabel}\n\n";
        $body .= "Message :\n{$old['message']}\n\n";
        $body .= "—\nEnvoyé depuis la page Contact.\n";

        $headers = [];
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-Type: text/plain; charset=UTF-8";
        $headers[] = "From: OFLABIM <no-reply@oflabim.fr>";
        $headers[] = "Reply-To: {$safeName} <{$safeEmail}>";

        error_log("[$reqId] CONTACT: sending mail to={$to} subject={$mailSubject}");
        error_log("[$reqId] CONTACT: headers=" . implode(" | ", $headers));

        $ok = @mail($to, $mailSubject, $body, implode("\r\n", $headers));

        if ($ok) {
            $flashSuccess = "Message envoyé ✅ Nous vous répondrons sous 24–48h ouvrées.";
            error_log("[$reqId] CONTACT: mail() returned TRUE => success flash set");

            // vider le formulaire après succès
            $old = ['name'=>'','email'=>'','phone'=>'','subject'=>'','message'=>''];
        } else {
            $errors['global'] = "Impossible d’envoyer le message pour le moment. Réessayez plus tard. Config SMTP requise";
            error_log("[$reqId] CONTACT: mail() returned FALSE => global error set");

            $lastError = error_get_last();
            if ($lastError) {
                error_log("[$reqId] CONTACT: last_error=" . print_r($lastError, true));
            }
        }
    }
}

error_log("[$reqId] CONTACT: rendering view. flash=" . (!empty($flashSuccess) ? 'YES' : 'NO') . " errors_count=" . count($errors));

// IMPORTANT : cette page controller doit ensuite rendre ta vue contact
// Ex: require_once(PATH_VIEWS . 'contact.php');
