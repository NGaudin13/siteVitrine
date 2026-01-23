<?php

// Email de réception (client)
$to = 'nicolasgaudin13@gmail.com';

// Variables pour la vue
$errors = [];
$flashSuccess = null;

// ID pour suivre une requête dans les logs
$reqId = date('Ymd_His') . '_' . bin2hex(random_bytes(3));

error_log("[$reqId] CONTACT: controller loaded | method=" . ($_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN'));

// Pré-remplissage (UX)
$old = [
    'name'    => '',
    'email'   => '',
    'phone'   => '',
    'subject' => '',
    'message' => '',
];

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {

    error_log("[$reqId] CONTACT: POST received");
    error_log("[$reqId] CONTACT: POST payload=" . print_r($_POST, true));

    // 1) Récup
    $old['name']    = trim($_POST['name'] ?? '');
    $old['email']   = trim($_POST['email'] ?? '');
    $old['phone']   = trim($_POST['phone'] ?? '');
    $old['subject'] = trim($_POST['subject'] ?? '');
    $old['message'] = trim($_POST['message'] ?? '');
    $rgpdAccepted   = isset($_POST['rgpd']);

    error_log("[$reqId] CONTACT: parsed fields name={$old['name']} email={$old['email']} subject={$old['subject']} rgpd=" . ($rgpdAccepted ? '1' : '0'));

    // 2) Validation minimale
    if ($old['name'] === '') {
        $errors['name'] = 'Le nom est obligatoire.';
    }

    if ($old['email'] === '' || !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email invalide.';
    }

    if ($old['subject'] === '') {
        $errors['subject'] = 'Veuillez choisir un sujet.';
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

    // 3) Envoi mail
    if (empty($errors)) {

        $safeName    = htmlspecialchars($old['name'], ENT_QUOTES, 'UTF-8');
        $safeEmail   = htmlspecialchars($old['email'], ENT_QUOTES, 'UTF-8');
        $safeSubject = htmlspecialchars($old['subject'], ENT_QUOTES, 'UTF-8');

        $mailSubject = "[OFLABIM] Nouveau message - " . $safeSubject;

        $body  = "Nouveau message depuis le site OFLABIM\n\n";
        $body .= "Nom : {$old['name']}\n";
        $body .= "Email : {$old['email']}\n";
        $body .= "Téléphone : " . ($old['phone'] ?: 'Non renseigné') . "\n";
        $body .= "Sujet : {$old['subject']}\n\n";
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

            // Log erreur PHP si dispo
            $lastError = error_get_last();
            if ($lastError) {
                error_log("[$reqId] CONTACT: last_error=" . print_r($lastError, true));
            }
        }
    }
}

error_log("[$reqId] CONTACT: rendering view. flash=" . (!empty($flashSuccess) ? 'YES' : 'NO') . " errors_count=" . count($errors));

