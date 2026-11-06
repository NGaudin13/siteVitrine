<?php
// =========================================================
// FICHIER : siteVitrine/scripts/changer_mot_de_passe.php
// Change le mot de passe d'un compte admin dans la base.
//
// Utilisation (terminal, depuis la racine du projet) :
//   C:\xampp\php\php.exe scripts\changer_mot_de_passe.php
//
// Le mot de passe n'est JAMAIS écrit dans le code ni dans Git :
// seul son hash (bcrypt) est enregistré en base.
// =========================================================

// SÉCURITÉ : ce script ne doit jamais être lancé depuis un navigateur.
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

// Les chemins de configuration.php sont relatifs à la racine du projet.
chdir(__DIR__ . '/..');
require_once './config/configuration.php';   // fournit $pdo

const LONGUEUR_MIN = 12;

function demander(string $question): string
{
    echo $question;
    return trim((string) fgets(STDIN));
}

function arreter(string $message): void
{
    fwrite(STDERR, "ERREUR : {$message}" . PHP_EOL);
    exit(1);
}

echo PHP_EOL . "=== Changement du mot de passe admin ===" . PHP_EOL;
echo "(attention : le mot de passe s'affiche pendant la saisie)" . PHP_EOL . PHP_EOL;

$email = demander("Email du compte admin : ");

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    arreter("email invalide.");
}

$motDePasse   = demander("Nouveau mot de passe (" . LONGUEUR_MIN . " caractères minimum) : ");
$confirmation = demander("Confirmez le mot de passe : ");

if ($motDePasse !== $confirmation) {
    arreter("les deux mots de passe ne correspondent pas.");
}

if (mb_strlen($motDePasse) < LONGUEUR_MIN) {
    arreter("mot de passe trop court (" . LONGUEUR_MIN . " caractères minimum).");
}

if (strtolower($motDePasse) === 'admin123') {
    arreter("ce mot de passe est public (il était dans le README), choisissez-en un autre.");
}

$hash = password_hash($motDePasse, PASSWORD_DEFAULT);

$stmt = $pdo->prepare(
    'UPDATE user SET password_hash = :hash, updated_at = NOW() WHERE email = :email'
);
$stmt->execute(['hash' => $hash, 'email' => $email]);

if ($stmt->rowCount() === 0) {
    arreter("aucun utilisateur trouvé avec l'email {$email}.");
}

echo PHP_EOL . "OK : mot de passe mis à jour pour {$email}." . PHP_EOL;
echo "Pensez à le mettre aussi dans tests/.env.local pour les tests." . PHP_EOL;