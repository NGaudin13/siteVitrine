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

        $isEditable = ($sectionId > 0 && !empty($blocks));

        $blockTitle = $blocks['title']  ?? null;
        $blockP1    = $blocks['text_1'] ?? null;
        $blockP2    = $blocks['text_2'] ?? null;
        $blockImg   = $blocks['image']  ?? null;

        // ===================== 5) POST: SAUVEGARDE =====================
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $postedSectionSlug = trim((string)($_POST['section_slug'] ?? ''));
            if ($postedSectionSlug === '') {
                $_SESSION['flashError'] = "Section invalide.";
                header('Location: index.php?page=adminAccueil');
                exit;
            }

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

            $blocks = $this->contentBlockModel->findBySectionIdIndexedBySlot($sectionId, true);
            $isEditable = !empty($blocks);

            if (!$isEditable) {
                $_SESSION['flashError'] = "Cette section n’est pas encore éditable (aucun content_block associé).";
                header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                exit;
            }

            // ------------------------------------------------------------------
            // UPLOAD IMAGE (commun) -> uniquement sections avec image unique
            // ------------------------------------------------------------------
            $src = '';
            $alt = '';

            if (in_array($selectedSlug, ['home-bim', 'home-about'], true)) {

                $src = trim((string)($_POST['image_src'] ?? ''));
                $alt = trim((string)($_POST['image_alt'] ?? ''));

                if ($alt === '') {
                    $_SESSION['flashError'] = "Le texte alternatif (alt) est obligatoire.";
                    header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                    exit;
                }

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
            }

            // ------------------------------------------------------------------
            // ROUTING PAR SECTION (IMPORTANT)
            // ------------------------------------------------------------------

            // ===== HOME-BIM : title + text_1 + text_2 + image
            if ($selectedSlug === 'home-bim') {

                $title = trim((string)($_POST['title'] ?? ''));
                $text1 = trim((string)($_POST['text_1'] ?? ''));
                $text2 = trim((string)($_POST['text_2'] ?? ''));

                if ($title === '' || $text1 === '' || $text2 === '') {
                    $_SESSION['flashError'] = "Titre + paragraphe 1 + paragraphe 2 obligatoires.";
                    header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                    exit;
                }

                $this->contentBlockModel->updateBySectionSlot($sectionId, 'title',  ['text' => $title]);
                $this->contentBlockModel->updateBySectionSlot($sectionId, 'text_1', ['text' => $text1]);
                $this->contentBlockModel->updateBySectionSlot($sectionId, 'text_2', ['text' => $text2]);
                $this->contentBlockModel->updateBySectionSlot($sectionId, 'image',  ['src' => $src, 'alt' => $alt]);
            }

            // ===== HOME-ABOUT : title + text_1 + stats + image (PAS de text_2)
            elseif ($selectedSlug === 'home-about') {

                $title = trim((string)($_POST['title'] ?? ''));
                $text1 = trim((string)($_POST['text_1'] ?? ''));

                $stat1 = trim((string)($_POST['stat_1_value'] ?? ''));
                $stat2 = trim((string)($_POST['stat_2_value'] ?? ''));

                if ($title === '' || $text1 === '') {
                    $_SESSION['flashError'] = "Titre + paragraphe obligatoires.";
                    header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                    exit;
                }

                if ($stat1 === '' || $stat2 === '') {
                    $_SESSION['flashError'] = "Les 2 statistiques sont obligatoires (ex: 45+ et 100%).";
                    header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                    exit;
                }

                $this->contentBlockModel->updateBySectionSlot($sectionId, 'title',        ['text' => $title]);
                $this->contentBlockModel->updateBySectionSlot($sectionId, 'text_1',       ['text' => $text1]);
                $this->contentBlockModel->updateBySectionSlot($sectionId, 'stat_1_value', ['text' => $stat1]);
                $this->contentBlockModel->updateBySectionSlot($sectionId, 'stat_2_value', ['text' => $stat2]);
                $this->contentBlockModel->updateBySectionSlot($sectionId, 'image',        ['src' => $src, 'alt' => $alt]);
            }

           elseif ($selectedSlug === 'home-domains') {

                // -------------------------------
                // 1) Titre + intro
                // -------------------------------
                $title = trim((string)($_POST['title'] ?? ''));
                $intro = trim((string)($_POST['intro'] ?? ''));

                if ($title === '' || $intro === '') {
                    $_SESSION['flashError'] = "Titre + intro obligatoires.";
                    header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                    exit;
                }

                // Ici tu peux rester en update (car ces slots existent déjà)
                // MAIS si tu veux béton, mets aussi en upsert (ci-dessous je fais upsert)
                $this->contentBlockModel->upsertBySectionSlot($sectionId, 'title', [
                    'type' => 'h2',
                    'text' => $title,
                    'order_index' => 10,
                    'is_active' => 1,
                ]);

                $this->contentBlockModel->upsertBySectionSlot($sectionId, 'intro', [
                    'type' => 'p',
                    'text' => $intro,
                    'order_index' => 20,
                    'is_active' => 1,
                ]);

                // -------------------------------
                // 2) Domaines : data
                // -------------------------------
                $MAX = 9;

                $domains = $_POST['domains'] ?? [];
                if (!is_array($domains)) $domains = [];

                // -------------------------------
                // 3) Upload config
                // -------------------------------
                $allowedMime = ['image/jpeg', 'image/png', 'image/webp'];
                $uploadDir = __DIR__ . '/../assets/images/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                // -------------------------------
                // 4) IMPORTANT : suppression réelle
                //    -> On désactive tout ce qui commence par domain_
                //    -> puis on réactive uniquement ce qui est posté
                // -------------------------------
                $this->contentBlockModel->disableBySectionSlotPrefix($sectionId, 'domain_');

                // -------------------------------
                // 5) Sauvegarde domaines (ordre affiché)
                // -------------------------------
                $pos = 0;

                foreach ($domains as $i => $row) {

                    $i = (int)$i;
                    if ($i < 1 || $i > $MAX) continue;

                    $t   = trim((string)($row['title'] ?? ''));
                    $d   = trim((string)($row['desc'] ?? ''));
                    $alt = trim((string)($row['alt'] ?? ''));
                    $src = trim((string)($row['image_src'] ?? ''));

                    // Validation minimale
                    if ($t === '' || $d === '' || $alt === '') {
                        $_SESSION['flashError'] = "Titre + description + alt obligatoires (domaine #{$i}).";
                        header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                        exit;
                    }

                    // -------------------------------
                    // Upload image par domaine
                    // name="domains[i][image_file]"
                    // -------------------------------
                    $hasUpload = !empty($_FILES['domains']['name'][$i]['image_file'] ?? '');
                    if ($hasUpload) {

                        $err = $_FILES['domains']['error'][$i]['image_file'] ?? UPLOAD_ERR_NO_FILE;
                        if ($err !== UPLOAD_ERR_OK) {
                            $_SESSION['flashError'] = "Erreur lors de l’upload de l’image (domaine #{$i}).";
                            header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                            exit;
                        }

                        $tmpName = $_FILES['domains']['tmp_name'][$i]['image_file'];
                        $size    = (int)($_FILES['domains']['size'][$i]['image_file'] ?? 0);

                        // mime check
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mime  = finfo_file($finfo, $tmpName);
                        finfo_close($finfo);

                        if (!in_array($mime, $allowedMime, true)) {
                            $_SESSION['flashError'] = "Format image non autorisé (JPG/PNG/WEBP) (domaine #{$i}).";
                            header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                            exit;
                        }

                        if ($size > 5 * 1024 * 1024) {
                            $_SESSION['flashError'] = "Image trop lourde (max 5 Mo) (domaine #{$i}).";
                            header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                            exit;
                        }

                        $ext = match ($mime) {
                            'image/jpeg' => 'jpg',
                            'image/png'  => 'png',
                            'image/webp' => 'webp',
                            default      => 'jpg'
                        };

                        $filename   = 'accueil_home-domains_' . $i . '_' . date('Ymd_His') . '.' . $ext;
                        $targetPath = $uploadDir . $filename;

                        if (!move_uploaded_file($tmpName, $targetPath)) {
                            $_SESSION['flashError'] = "Impossible d’enregistrer l’image (domaine #{$i}).";
                            header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                            exit;
                        }

                        $src = 'assets/images/' . $filename;
                    }

                    // Si pas d’upload, il faut avoir un src existant (sinon carte inutilisable)
                    if ($src === '') {
                        $_SESSION['flashError'] = "Le src est obligatoire (ou upload) (domaine #{$i}).";
                        header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                        exit;
                    }

                    // Ordre : basé sur l’ordre d’arrivée dans $_POST['domains']
                    $pos++;
                    $baseOrder = 100 + ($pos * 10); // 110, 120, 130...

                    // -------------------------------
                    // UPSERT : crée si absent, update sinon
                    // + is_active=1 => réactive ceux qui existent
                    // -------------------------------
                    $this->contentBlockModel->upsertBySectionSlot($sectionId, "domain_{$i}_title", [
                        'type' => 'h3',
                        'text' => $t,
                        'order_index' => $baseOrder,
                        'is_active' => 1,
                    ]);

                    $this->contentBlockModel->upsertBySectionSlot($sectionId, "domain_{$i}_desc", [
                        'type' => 'p',
                        'text' => $d,
                        'order_index' => $baseOrder + 1,
                        'is_active' => 1,
                    ]);

                    $this->contentBlockModel->upsertBySectionSlot($sectionId, "domain_{$i}_img", [
                        'type' => 'img',
                        'src'  => $src,
                        'alt'  => $alt,
                        'order_index' => $baseOrder + 2,
                        'is_active' => 1,
                    ]);
                }

            }
            
            // ===== AUTRES : tu peux gérer plus tard, mais on évite de casser
            else {
                $_SESSION['flashError'] = "Section non gérée côté sauvegarde : " . $selectedSlug;
                header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
                exit;
            }

            $_SESSION['flashSuccess'] = "Section mise à jour : " . $selectedSection->getAdminTitle();
            header('Location: index.php?page=adminAccueil&section=' . urlencode($selectedSlug));
            exit;
        }

        return [
            'flashSuccess'    => $flashSuccess,
            'flashError'      => $flashError,
            'sections'        => $sections,
            'selectedSlug'    => $selectedSlug,
            'selectedSection' => $selectedSection,
            'isEditable'      => $isEditable,

            // Compat (si certaines vues les utilisent)
            'blockTitle'      => $blockTitle,
            'blockP1'         => $blockP1,
            'blockP2'         => $blockP2,
            'blockImg'        => $blockImg,

            // Le mieux : les vues utilisent $blocks[]
            'blocks'          => $blocks,
        ];
    }
}
