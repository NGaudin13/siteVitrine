<?php
// controllers/AdminPresentationController.php

session_start();

require_once PATH_MODELS . 'PageModel.php';
require_once PATH_MODELS . 'SectionModel.php';
require_once PATH_MODELS . 'ContentBlockModel.php';

class AdminPresentationController
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
        $flashSuccess = $_SESSION['flashSuccess'] ?? null;
        $flashError   = $_SESSION['flashError'] ?? null;
        unset($_SESSION['flashSuccess'], $_SESSION['flashError']);

        // 1) PAGE PRESENTATION
        $page = $this->pageModel->findBySlug('presentation');
        if (!$page) {
            http_response_code(404);
            return [
                'flashError' => "Page 'presentation' introuvable.",
                'sections'   => [],
            ];
        }

        // 2) SECTIONS
        $sections = $this->sectionModel->findByPageId((int)$page->getId(), true);
        if (empty($sections)) {
            http_response_code(404);
            return [
                'flashError' => "Aucune section trouvée pour la page 'presentation'.",
                'sections'   => [],
            ];
        }

        // 3) SECTION SELECTIONNEE
        $selectedSlug    = trim((string)($_GET['section'] ?? ''));
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

        $sectionId = $selectedSection ? (int)$selectedSection->getId() : 0;

        // 4) BLOCKS
        $blocks = [];
        if ($sectionId > 0) {
            $blocks = $this->contentBlockModel->findBySectionIdIndexedBySlot($sectionId, true);
        }
        $isEditable = ($sectionId > 0 && !empty($blocks));

        // 5) POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $postedSectionSlug = trim((string)($_POST['section_slug'] ?? ''));
            if ($postedSectionSlug === '') {
                $_SESSION['flashError'] = "Section invalide.";
                header('Location: index.php?page=adminPresentation');
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
                header('Location: index.php?page=adminPresentation');
                exit;
            }

            $selectedSection = $postedSection;
            $selectedSlug    = $selectedSection->getSlug();
            $sectionId       = (int)$selectedSection->getId();

            // reload blocks + règle éditable
            $blocks = $this->contentBlockModel->findBySectionIdIndexedBySlot($sectionId, true);
            $isEditable = !empty($blocks);

            if (!$isEditable) {
                $_SESSION['flashError'] = "Cette section n’est pas encore éditable (aucun content_block associé).";
                header('Location: index.php?page=adminPresentation&section=' . urlencode($selectedSlug));
                exit;
            }

            // ===================== presentation-about =====================
            if ($selectedSlug === 'presentation-about') {

                $title = trim((string)($_POST['title'] ?? ''));
                $text1 = trim((string)($_POST['text_1'] ?? ''));
                $text2 = trim((string)($_POST['text_2'] ?? ''));
                $src   = trim((string)($_POST['image_src'] ?? ''));
                $alt   = trim((string)($_POST['image_alt'] ?? ''));

                if ($title === '' || $text1 === '' || $text2 === '') {
                    $_SESSION['flashError'] = "Titre et paragraphes obligatoires.";
                    header('Location: index.php?page=adminPresentation&section=' . urlencode($selectedSlug));
                    exit;
                }

                if ($alt === '') {
                    $_SESSION['flashError'] = "Le alt est obligatoire.";
                    header('Location: index.php?page=adminPresentation&section=' . urlencode($selectedSlug));
                    exit;
                }

                // (upload optionnel si tu veux)

                if ($src === '') {
                    $_SESSION['flashError'] = "Le src de l’image est obligatoire (ou upload).";
                    header('Location: index.php?page=adminPresentation&section=' . urlencode($selectedSlug));
                    exit;
                }

                $this->contentBlockModel->updateBySectionSlot($sectionId, 'title',  ['text' => $title]);
                $this->contentBlockModel->updateBySectionSlot($sectionId, 'text_1', ['text' => $text1]);
                $this->contentBlockModel->updateBySectionSlot($sectionId, 'text_2', ['text' => $text2]);
                $this->contentBlockModel->updateBySectionSlot($sectionId, 'image',  ['src' => $src, 'alt' => $alt]);
            }

            // ===================== presentation-path =====================
            if ($selectedSlug === 'presentation-path') {

                $col1Title = trim((string)($_POST['col1_title'] ?? ''));
                $col1Intro = trim((string)($_POST['col1_intro'] ?? ''));
                $col3Title = trim((string)($_POST['col3_title'] ?? ''));
                $col3Intro = trim((string)($_POST['col3_intro'] ?? ''));

                if ($col1Title === '' || $col1Intro === '' || $col3Title === '' || $col3Intro === '') {
                    $_SESSION['flashError'] = "Les titres + intros des 2 blocs sont obligatoires.";
                    header('Location: index.php?page=adminPresentation&section=' . urlencode($selectedSlug));
                    exit;
                }

                // 1) update titres/intro
                $this->contentBlockModel->updateBySectionSlot($sectionId, 'col1_title', ['text' => $col1Title]);
                $this->contentBlockModel->updateBySectionSlot($sectionId, 'col1_intro', ['text' => $col1Intro]);
                $this->contentBlockModel->updateBySectionSlot($sectionId, 'col3_title', ['text' => $col3Title]);
                $this->contentBlockModel->updateBySectionSlot($sectionId, 'col3_intro', ['text' => $col3Intro]);

                // 2) nettoyer (désactiver) les anciens items
                // -> il faut que tu aies ajouté ces méthodes au model
                $this->contentBlockModel->disableBySectionSlotPrefix($sectionId, 'timeline_');
                $this->contentBlockModel->disableBySectionSlotPrefix($sectionId, 'edu_');

                // 3) recréer à partir du POST (renuméroté proprement 1..N)
                $timeline = $_POST['timeline'] ?? [];
                $n = 0;
                foreach ($timeline as $row) {
                    $t  = trim((string)($row['title'] ?? ''));
                    $d  = trim((string)($row['desc'] ?? ''));
                    $dt = trim((string)($row['date'] ?? ''));

                    if ($t === '' && $d === '' && $dt === '') {
                        continue;
                    }

                    $n++;
                    $baseOrder = 100 + ($n * 10);

                    $this->contentBlockModel->upsertBySectionSlot($sectionId, "timeline_{$n}_title", [
                        'type' => 'span', 'text' => $t, 'order_index' => $baseOrder + 0, 'is_active' => 1
                    ]);
                    $this->contentBlockModel->upsertBySectionSlot($sectionId, "timeline_{$n}_desc", [
                        'type' => 'p', 'text' => $d, 'order_index' => $baseOrder + 1, 'is_active' => 1
                    ]);
                    $this->contentBlockModel->upsertBySectionSlot($sectionId, "timeline_{$n}_date", [
                        'type' => 'span', 'text' => $dt, 'order_index' => $baseOrder + 2, 'is_active' => 1
                    ]);
                }

                $edu = $_POST['edu'] ?? [];
                $m = 0;
                foreach ($edu as $row) {
                    $t   = trim((string)($row['title'] ?? ''));
                    $d   = trim((string)($row['desc'] ?? ''));
                    $lvl = trim((string)($row['level'] ?? ''));

                    if ($t === '' && $d === '' && $lvl === '') {
                        continue;
                    }

                    $m++;
                    $baseOrder = 500 + ($m * 10);

                    $this->contentBlockModel->upsertBySectionSlot($sectionId, "edu_{$m}_title", [
                        'type' => 'span', 'text' => $t, 'order_index' => $baseOrder + 0, 'is_active' => 1
                    ]);
                    $this->contentBlockModel->upsertBySectionSlot($sectionId, "edu_{$m}_desc", [
                        'type' => 'p', 'text' => $d, 'order_index' => $baseOrder + 1, 'is_active' => 1
                    ]);
                    $this->contentBlockModel->upsertBySectionSlot($sectionId, "edu_{$m}_level", [
                        'type' => 'span', 'text' => $lvl, 'order_index' => $baseOrder + 2, 'is_active' => 1
                    ]);
                }
            }

            $_SESSION['flashSuccess'] = "Section mise à jour : " . $selectedSection->getAdminTitle();
            header('Location: index.php?page=adminPresentation&section=' . urlencode($selectedSlug));
            exit;
        }

        return [
            'flashSuccess'    => $flashSuccess,
            'flashError'      => $flashError,
            'sections'        => $sections,
            'selectedSlug'    => $selectedSlug,
            'selectedSection' => $selectedSection,
            'isEditable'      => $isEditable,
            'blocks'          => $blocks,
        ];
    }
}
