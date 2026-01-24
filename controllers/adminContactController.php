<?php
// controllers/AdminContactController.php

session_start();

require_once PATH_MODELS . 'PageModel.php';
require_once PATH_MODELS . 'SectionModel.php';
require_once PATH_MODELS . 'ContentBlockModel.php';

class AdminContactController
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

        // ===================== 1) PAGE CONTACT =====================
        $page = $this->pageModel->findBySlug('contact');
        if (!$page) {
            http_response_code(404);
            return [
                'flashError' => "Page 'contact' introuvable.",
                'sections'   => [],
            ];
        }

        // ===================== 2) SECTIONS =====================
        $sections = $this->sectionModel->findByPageId((int)$page->getId(), true);
        if (empty($sections)) {
            http_response_code(404);
            return [
                'flashError' => "Aucune section trouvée pour la page 'contact'.",
                'sections'   => [],
            ];
        }

        // ===================== 3) SECTION SÉLECTIONNÉE =====================
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

        // ===================== 4) BLOCKS =====================
        $blocks = [];
        if ($sectionId > 0) {
            $blocks = $this->contentBlockModel->findBySectionIdIndexedBySlot($sectionId, true);
        }
        $isEditable = ($sectionId > 0 && !empty($blocks));

        // ===================== 5) POST : SAVE =====================
        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {

            $postedSectionSlug = trim((string)($_POST['section_slug'] ?? ''));
            if ($postedSectionSlug === '') {
                $_SESSION['flashError'] = "Section invalide.";
                header('Location: index.php?page=adminContact');
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
                header('Location: index.php?page=adminContact');
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
                header('Location: index.php?page=adminContact&section=' . urlencode($selectedSlug));
                exit;
            }

            // ===================== contact-form : sujets (LIGNES subject_*) =====================
            if ($selectedSlug === 'contact-nature-demande') {

                // attend un tableau : subjects[label] + subjects[value] + subjects[active]
                // ex : subjects[0][label], subjects[0][value], subjects[0][active]
                $subjects = $_POST['subjects'] ?? [];

                // 1) Désactiver tous les anciens sujets
                $this->contentBlockModel->disableBySectionSlotPrefix($sectionId, 'subject_');

                // 2) Recréer / upsert proprement
                $n = 0;
                foreach ($subjects as $row) {

                    $label  = trim((string)($row['label'] ?? ''));
                    $value  = trim((string)($row['value'] ?? ''));
                    $active = isset($row['active']) ? 1 : 0;

                    if ($label === '' && $value === '') {
                        continue;
                    }

                    // si le client laisse value vide, on le force (minimum)
                    if ($value === '') {
                        // slug simple (sans accents)
                        $value = $this->slugify($label);
                    }

                    if ($value === '') {
                        continue;
                    }

                    $n++;
                    $order = $n * 10;

                    $slot = 'subject_' . $value;

                    // type = 'p' (car ton enum l’accepte)
                    $this->contentBlockModel->upsertBySectionSlot($sectionId, $slot, [
                        'type'       => 'p',
                        'text'       => $label !== '' ? $label : $value,
                        'order_index'=> $order,
                        'is_active'  => $active,
                    ]);
                }

                if ($n === 0) {
                    $_SESSION['flashError'] = "Ajoute au moins un sujet.";
                    header('Location: index.php?page=adminContact&section=' . urlencode($selectedSlug));
                    exit;
                }

            } else {
                $_SESSION['flashError'] = "Section non gérée côté sauvegarde : " . $selectedSlug;
                header('Location: index.php?page=adminContact&section=' . urlencode($selectedSlug));
                exit;
            }

            $_SESSION['flashSuccess'] = "Section mise à jour : " . $selectedSection->getAdminTitle();
            header('Location: index.php?page=adminContact&section=' . urlencode($selectedSlug));
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

    private function slugify(string $str): string
    {
        $str = trim(mb_strtolower($str, 'UTF-8'));
        $str = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);
        $str = preg_replace('/[^a-z0-9]+/i', '-', $str);
        $str = trim($str, '-');
        $str = preg_replace('/-+/', '-', $str);
        return (string)$str;
    }
}
