<?php
// ===================== CONTROLEUR : controllers/AdminAccueilController.php =====================

session_start();

require_once PATH_MODELS . 'PageModel.php';
require_once PATH_MODELS . 'SectionModel.php';
require_once PATH_MODELS . 'ContentBlockModel.php';

class AdminAccueilController
{
    private PageModel $pageModel;
    private SectionModel $sectionModel;
    private ContentBlockModel $contentBlockModel;

    public function __construct(PDO $pdo)
    {
        $this->pageModel         = new PageModel($pdo);
        $this->sectionModel      = new SectionModel($pdo);
        $this->contentBlockModel = new ContentBlockModel($pdo);
    }

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
            return [
                'flashError' => "Page 'accueil' introuvable.",
                'sections'   => [],
            ];
        }

        // ===================== 2) SECTIONS =====================
        $sections = $this->sectionModel->findByPageId((int) $page->getId(), true);
        if (empty($sections)) {
            http_response_code(404);
            return [
                'flashError' => "Aucune section trouvée pour la page 'accueil'.",
                'sections'   => [],
            ];
        }

        // ===================== 3) SECTION SÉLECTIONNÉE (SANS DÉFAUT) =====================
        $selectedSlug = trim((string)($_GET['section'] ?? ''));
        $selectedSection = null;

        if ($selectedSlug !== '') {
            foreach ($sections as $s) {
                if ($s->getSlug() === $selectedSlug) {
                    $selectedSection = $s;
                    break;
                }
            }
            // slug invalide => on remet à vide (l’utilisateur re-choisit)
            if (!$selectedSection) {
                $selectedSlug = '';
            }
        }

        $sectionId = $selectedSection ? (int) $selectedSection->getId() : 0;

        // ===================== 4) BLOCKS (si section choisie) =====================
        $blocks = [];
        if ($sectionId > 0) {
            $blocks = $this->contentBlockModel->findBySectionIdIndexedBySlot($sectionId, true);
        }

        // ✅ Ta règle simple : éditable si on trouve AU MOINS 1 content_block
        $isEditable = ($sectionId > 0 && !empty($blocks));

        $blockTitle = $blocks['title']  ?? null;
        $blockP1    = $blocks['text_1'] ?? null;
        $blockP2    = $blocks['text_2'] ?? null;
        $blockImg   = $blocks['image']  ?? null;

        // ===================== 5) POST: SAUVEGARDE (seulement si éditable) =====================
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $postedSectionSlug = trim((string)($_POST['section_slug'] ?? ''));
            if ($postedSectionSlug === '') {
                $_SESSION['flashError'] = "Section invalide.";
                header('Location: index.php?page=adminAccueil');
                exit;
            }

            // re-check slug => section
            $postedSection = null;
            foreach ($sections as $s) {
                if ($s->getSlug() === $postedSectionSlug) {
                    $postedSection = $s;
                    break;
                }
            }

            if (!$postedSection) {
                $_SESSION['flashError'] = "Section invalide.";
                header('Location: index.php?page=adminAccueil');
                exit;
            }

            $selectedSection = $postedSection;
            $selectedSlug    = $selectedSection->getSlug();
            $sectionId       = (int)$selectedSection->getId();

            // reload blocks => ta règle
            $blocks = $this->contentBlockModel->findBySectionIdIndexedBySlot($sectionId, true);
            $isEditable = !empty($blocks);

            if (!$isEditable) {
                $_SESSION['flashError'] = "Cette section n’est pas encore éditable (aucun content_block associé).";
                header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                exit;
            }

            // Champs
            $title = trim((string)($_POST['title'] ?? ''));
            $text1 = trim((string)($_POST['text_1'] ?? ''));
            $text2 = trim((string)($_POST['text_2'] ?? ''));
            $src   = trim((string)($_POST['image_src'] ?? ''));
            $alt   = trim((string)($_POST['image_alt'] ?? ''));

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

            // UPLOAD (inchangé, juste nom de fichier plus logique)
            if (!empty($_FILES['image_file']['name'])) {

                if ($_FILES['image_file']['error'] !== UPLOAD_ERR_OK) {
                    $_SESSION['flashError'] = "Erreur lors de l’upload de l’image.";
                    header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                    exit;
                }

                $allowedMime = ['image/jpeg', 'image/png', 'image/webp'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime  = finfo_file($finfo, $_FILES['image_file']['tmp_name']);
                finfo_close($finfo);

                if (!in_array($mime, $allowedMime, true)) {
                    $_SESSION['flashError'] = "Format non autorisé (JPG/PNG/WEBP uniquement).";
                    header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                    exit;
                }

                if ($_FILES['image_file']['size'] > 5 * 1024 * 1024) {
                    $_SESSION['flashError'] = "Image trop lourde (max 5 Mo).";
                    header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                    exit;
                }

                $uploadDir = __DIR__ . '/../assets/images/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $ext = match ($mime) {
                    'image/jpeg' => 'jpg',
                    'image/png'  => 'png',
                    'image/webp' => 'webp',
                    default      => 'jpg'
                };

                $filename   = 'accueil_' . $selectedSlug . '_' . date('Ymd_His') . '.' . $ext;
                $targetPath = $uploadDir . $filename;

                if (!move_uploaded_file($_FILES['image_file']['tmp_name'], $targetPath)) {
                    $_SESSION['flashError'] = "Impossible d’enregistrer l’image sur le serveur.";
                    header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                    exit;
                }

                $src = 'assets/images/' . $filename;
            }

            if ($src === '') {
                $_SESSION['flashError'] = "Le src de l’image est obligatoire (ou upload une image).";
                header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                exit;
            }

            // UPDATE (inchangé)
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'title',  ['text' => $title]);
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'text_1', ['text' => $text1]);
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'text_2', ['text' => $text2]);
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'image',  ['src' => $src, 'alt' => $alt]);

            $_SESSION['flashSuccess'] = "Section mise à jour : " . $selectedSection->getAdminTitle();
            header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
            exit;
        }

        return [
            'flashSuccess'   => $flashSuccess,
            'flashError'     => $flashError,
            'sections'       => $sections,
            'selectedSlug'   => $selectedSlug,
            'selectedSection'=> $selectedSection,
            'isEditable'     => $isEditable,
            'blockTitle'     => $blockTitle,
            'blockP1'        => $blockP1,
            'blockP2'        => $blockP2,
            'blockImg'       => $blockImg,
        ];
    }
}
