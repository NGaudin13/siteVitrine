<?php
// ===================== CONTROLEUR : controllers/AdminAccueilController.php =====================

// ⚠️ Idéalement: session_start() UNE seule fois dans index.php (ou bootstrap).
// Mais si tu le laisses ici, ça peut marcher tant que rien n'a déjà envoyé du HTML.
session_start();

require_once PATH_MODELS . 'PageModel.php';
require_once PATH_MODELS . 'SectionModel.php';
require_once PATH_MODELS . 'ContentBlockModel.php';

class AdminAccueilController
{
    private PageModel $pageModel;
    private SectionModel $sectionModel;
    private ContentBlockModel $contentBlockModel;

    // Section par défaut au début
    private string $defaultSectionSlug = 'home-bim';

    public function __construct(PDO $pdo)
    {
        $this->pageModel         = new PageModel($pdo);
        $this->sectionModel      = new SectionModel($pdo);
        $this->contentBlockModel = new ContentBlockModel($pdo);
    }

    // ✅ IMPORTANT : on retourne un tableau de données au lieu d'afficher la vue ici
    public function index(): array
    {
        // ===================== FLASH =====================
        $flashSuccess = $_SESSION['flashSuccess'] ?? null;
        $flashError   = $_SESSION['flashError'] ?? null;
        unset($_SESSION['flashSuccess'], $_SESSION['flashError']);

        // ===================== 1) PAGE ACCUEIL =====================
        $page = $this->pageModel->findBySlug('accueil');

        if (!$page) {
            http_response_code(404);
            echo "Page 'accueil' introuvable";
            return [];
        }

        // ===================== 2) SECTIONS DE L'ACCUEIL =====================
        $sections = $this->sectionModel->findByPageId((int) $page->getId(), true);

        if (empty($sections)) {
            http_response_code(404);
            echo "Aucune section trouvée pour la page 'accueil'";
            return [];
        }

        // ===================== 3) SECTION SÉLECTIONNÉE =====================
        $selectedSlug = trim((string) ($_GET['section'] ?? $this->defaultSectionSlug));
        if ($selectedSlug === '') {
            $selectedSlug = $this->defaultSectionSlug;
        }

        $selectedSection = null;
        foreach ($sections as $s) {
            if ($s->getSlug() === $selectedSlug) {
                $selectedSection = $s;
                break;
            }
        }

        // fallback: si slug invalide => première section
        if (!$selectedSection) {
            $selectedSection = $sections[0];
            $selectedSlug = $selectedSection->getSlug();
        }

        $sectionId = (int) $selectedSection->getId();

        // ===================== 4) POST: SAUVEGARDE =====================
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Petite sécurité : on force la section via champ hidden
            $postedSectionSlug = trim((string)($_POST['section_slug'] ?? ''));
            if ($postedSectionSlug !== '' && $postedSectionSlug !== $selectedSlug) {

                $selectedSlug = $postedSectionSlug;

                $tmp = null;
                foreach ($sections as $s) {
                    if ($s->getSlug() === $selectedSlug) {
                        $tmp = $s;
                        break;
                    }
                }

                if ($tmp) {
                    $selectedSection = $tmp;
                    $sectionId = (int) $selectedSection->getId();
                } else {
                    $_SESSION['flashError'] = "Section invalide.";
                    header('Location: index.php?page=adminAccueil');
                    exit;
                }
            }

            // Champs
            $title = trim((string)($_POST['title'] ?? ''));
            $text1 = trim((string)($_POST['text_1'] ?? ''));
            $text2 = trim((string)($_POST['text_2'] ?? ''));
            $src   = trim((string)($_POST['image_src'] ?? ''));
            $alt   = trim((string)($_POST['image_alt'] ?? ''));

            // Validations simples
            if ($title === '' || $text1 === '' || $text2 === '') {
                $_SESSION['flashError'] = "Titre et paragraphes obligatoires.";
                header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                exit;
            }

            if ($alt === '') {
                $_SESSION['flashError'] = "Le texte alternatif (alt) est obligatoire.";
                header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                exit;
            }

            // ================= IMAGE UPLOAD (dans assets/images) =================
            // Si un fichier est envoyé => on remplace le src automatiquement
            if (!empty($_FILES['image_file']['name'])) {

                if ($_FILES['image_file']['error'] !== UPLOAD_ERR_OK) {
                    $_SESSION['flashError'] = "Erreur lors de l’upload de l’image.";
                    header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                    exit;
                }

                // Sécurité: formats autorisés
                $allowedMime = ['image/jpeg', 'image/png', 'image/webp'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime  = finfo_file($finfo, $_FILES['image_file']['tmp_name']);
                finfo_close($finfo);

                if (!in_array($mime, $allowedMime, true)) {
                    $_SESSION['flashError'] = "Format non autorisé (JPG/PNG/WEBP uniquement).";
                    header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                    exit;
                }

                // Taille max (5 Mo)
                if ($_FILES['image_file']['size'] > 5 * 1024 * 1024) {
                    $_SESSION['flashError'] = "Image trop lourde (max 5 Mo).";
                    header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                    exit;
                }

                // Dossier cible (assets/images)
                $uploadDir = __DIR__ . '/../assets/images/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                // Extension propre
                $ext = match ($mime) {
                    'image/jpeg' => 'jpg',
                    'image/png'  => 'png',
                    'image/webp' => 'webp',
                    default      => 'jpg'
                };

                // Nom unique
                $filename   = 'accueil_homeBim_' . date('Ymd_His') . '.' . $ext;
                $targetPath = $uploadDir . $filename;

                if (!move_uploaded_file($_FILES['image_file']['tmp_name'], $targetPath)) {
                    $_SESSION['flashError'] = "Impossible d’enregistrer l’image sur le serveur.";
                    header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                    exit;
                }

                // ✅ On remplace le src automatiquement (chemin public)
                $src = 'assets/images/' . $filename;
            }

            // Si pas d'upload, on exige un src non vide
            if ($src === '') {
                $_SESSION['flashError'] = "Le src de l’image est obligatoire (ou upload une image).";
                header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                exit;
            }

            // ===================== UPDATE BDD (slots home-bim) =====================
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'title',  ['text' => $title]);
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'text_1', ['text' => $text1]);
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'text_2', ['text' => $text2]);
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'image',  ['src' => $src, 'alt' => $alt]);

            $_SESSION['flashSuccess'] = "Section mise à jour : " . $selectedSection->getAdminTitle();
            header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
            exit;
        }

        // ===================== 5) GET: BLOCKS SECTION SÉLECTIONNÉE =====================
        $blocks = $this->contentBlockModel->findBySectionIdIndexedBySlot($sectionId, true);

        $blockTitle = $blocks['title']  ?? null;
        $blockP1    = $blocks['text_1'] ?? null;
        $blockP2    = $blocks['text_2'] ?? null;
        $blockImg   = $blocks['image']  ?? null;

        // ===================== 6) RENDER (on retourne les variables) =====================
        return [
            'flashSuccess' => $flashSuccess,
            'flashError'   => $flashError,
            'sections'     => $sections,
            'selectedSlug' => $selectedSlug,
            'blockTitle'   => $blockTitle,
            'blockP1'      => $blockP1,
            'blockP2'      => $blockP2,
            'blockImg'     => $blockImg,
        ];
    }
}
