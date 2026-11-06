<?php
// =========================================================
// FICHIER : siteVitrine/lib/ImageUpload.php
// Envoi d'images depuis l'admin : UN seul endroit pour tous
// les contrôles de sécurité (avant, ce code était copié 2 fois).
//
// Contrôles :
//   - le fichier vient bien d'un envoi HTTP (is_uploaded_file)
//   - taille max 5 Mo
//   - type lu dans le CONTENU du fichier (finfo), pas dans son nom
//   - c'est réellement une image lisible (getimagesize)
//   - extension IMPOSÉE d'après le type (jamais celle envoyée)
//   - nom de fichier généré par le serveur (date + aléatoire)
// =========================================================

final class ImageUpload
{
    private const TYPES_AUTORISES = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    ];

    private const TAILLE_MAX = 5 * 1024 * 1024;   // 5 Mo

    private const DOSSIER = __DIR__ . '/../assets/images/';
    private const URL     = 'assets/images/';

    /**
     * Fichier d'un champ simple (<input type="file" name="image_file">).
     * Renvoie null si aucun fichier n'a été choisi.
     */
    public static function depuisChamp(string $nom): ?array
    {
        $f = $_FILES[$nom] ?? null;

        if (!is_array($f) || ($f['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        return $f;
    }

    /**
     * Fichier d'un champ en tableau (<input name="domains[3][image_file]">).
     * Renvoie null si aucun fichier n'a été choisi.
     */
    public static function depuisTableauMultiple(string $nom, int|string $cle, string $sousChamp): ?array
    {
        $f = $_FILES[$nom] ?? null;

        if (!is_array($f) || !isset($f['error'][$cle][$sousChamp])) {
            return null;
        }
        if ($f['error'][$cle][$sousChamp] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        return [
            'name'     => $f['name'][$cle][$sousChamp] ?? '',
            'type'     => $f['type'][$cle][$sousChamp] ?? '',
            'tmp_name' => $f['tmp_name'][$cle][$sousChamp] ?? '',
            'error'    => $f['error'][$cle][$sousChamp],
            'size'     => $f['size'][$cle][$sousChamp] ?? 0,
        ];
    }

    /**
     * Vérifie le fichier. Lance InvalidArgumentException avec un message
     * compréhensible pour l'administrateur si quelque chose ne va pas.
     */
    public static function verifier(array $f, string $contexte = ''): void
    {
        $erreur = (int) ($f['error'] ?? UPLOAD_ERR_NO_FILE);

        if ($erreur === UPLOAD_ERR_INI_SIZE || $erreur === UPLOAD_ERR_FORM_SIZE) {
            throw new InvalidArgumentException("Image trop lourde{$contexte}.");
        }
        if ($erreur !== UPLOAD_ERR_OK || !is_uploaded_file((string) ($f['tmp_name'] ?? ''))) {
            throw new InvalidArgumentException("Erreur lors de l’envoi de l’image{$contexte}.");
        }
        if ((int) $f['size'] > self::TAILLE_MAX) {
            throw new InvalidArgumentException("Image trop lourde (5 Mo maximum){$contexte}.");
        }
        if (!isset(self::TYPES_AUTORISES[self::typeReel($f)])) {
            throw new InvalidArgumentException("Format non autorisé (JPG, PNG ou WEBP uniquement){$contexte}.");
        }
        if (@getimagesize($f['tmp_name']) === false) {
            throw new InvalidArgumentException("Le fichier n’est pas une image valide{$contexte}.");
        }
    }

    /**
     * Déplace l'image (déjà vérifiée) dans assets/images/ et renvoie
     * son chemin public, ex : assets/images/accueil_home-intro_20261104_1530_a1b2c3.jpg
     */
    public static function enregistrer(array $f, string $prefixe): string
    {
        $extension = self::TYPES_AUTORISES[self::typeReel($f)];
        $prefixe   = preg_replace('/[^a-z0-9_-]/i', '', $prefixe) ?: 'image';
        $nom       = $prefixe . '_' . date('Ymd_His') . '_' . bin2hex(random_bytes(3)) . '.' . $extension;

        if (!is_dir(self::DOSSIER) && !mkdir(self::DOSSIER, 0755, true)) {
            throw new RuntimeException('Dossier des images impossible à créer.');
        }
        if (!move_uploaded_file($f['tmp_name'], self::DOSSIER . $nom)) {
            throw new RuntimeException("Impossible d'enregistrer l'image {$nom}.");
        }
        @chmod(self::DOSSIER . $nom, 0644);   // lecture seule, jamais exécutable

        return self::URL . $nom;
    }

    /** Type MIME lu dans le contenu du fichier. */
    private static function typeReel(array $f): string
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $type  = finfo_file($finfo, (string) $f['tmp_name']) ?: '';
        finfo_close($finfo);

        return $type;
    }
}