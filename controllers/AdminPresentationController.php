<?php
// =========================================================
// FICHIER : siteVitrine/controllers/AdminPresentationController.php
// Back-office : édition des sections de la page Présentation.
//
// Même règle que l'accueil : on valide tout, puis on écrit
// en base dans UNE transaction (tout ou rien).
// =========================================================

require_once PATH_MODELS . 'PageModel.php';
require_once PATH_MODELS . 'SectionModel.php';
require_once PATH_MODELS . 'ContentBlockModel.php';

class AdminPresentationController
{
    private PDO $pdo;
    private PageModel $pageModel;
    private SectionModel $sectionModel;
    private ContentBlockModel $contentBlockModel;

    public function __construct(PDO $pdo)
    {
        $this->pdo               = $pdo;
        $this->pageModel         = new PageModel($pdo);
        $this->sectionModel      = new SectionModel($pdo);
        $this->contentBlockModel = new ContentBlockModel($pdo);
    }

    public function index(): array
    {
        $flashSuccess = $_SESSION['flashSuccess'] ?? null;
        $flashError   = $_SESSION['flashError'] ?? null;
        unset($_SESSION['flashSuccess'], $_SESSION['flashError']);

        // 1) PAGE PRÉSENTATION
        $page = $this->pageModel->findBySlug('presentation');
        if (!$page) {
            http_response_code(404);
            return ['flashError' => "Page 'presentation' introuvable.", 'sections' => []];
        }

        // 2) SECTIONS
        $sections = $this->sectionModel->findByPageId((int) $page->getId(), true);
        if (empty($sections)) {
            http_response_code(404);
            return ['flashError' => "Aucune section trouvée pour la page 'presentation'.", 'sections' => []];
        }

        // 3) POST : SAUVEGARDE
        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
            $this->enregistrer($sections);   // redirige toujours
        }

        // 4) SECTION SÉLECTIONNÉE
        $selectedSection = $this->trouverSection($sections, (string) ($_GET['section'] ?? ''));
        $selectedSlug    = $selectedSection ? $selectedSection->getSlug() : '';
        $sectionId       = $selectedSection ? (int) $selectedSection->getId() : 0;

        $blocks     = $sectionId > 0
            ? $this->contentBlockModel->findBySectionIdIndexedBySlot($sectionId, true)
            : [];
        $isEditable = ($sectionId > 0 && !empty($blocks));

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

    /* ============================================================
       ENREGISTREMENT
       ============================================================ */

    private function enregistrer(array $sections): never
    {
        $section = $this->trouverSection($sections, (string) ($_POST['section_slug'] ?? ''));

        if (!$section) {
            $this->rediriger('', erreur: 'Section invalide.');
        }

        $slug      = $section->getSlug();
        $sectionId = (int) $section->getId();

        if (empty($this->contentBlockModel->findBySectionIdIndexedBySlot($sectionId, true))) {
            $this->rediriger($slug, erreur: "Cette section n’est pas encore éditable (aucun contenu associé).");
        }

        try {
            match ($slug) {
                'presentation-path' => $this->enregistrerParcours($sectionId),
                default             => throw new InvalidArgumentException("Section non gérée : {$slug}"),
            };
        } catch (InvalidArgumentException $e) {
            $this->rediriger($slug, erreur: $e->getMessage());
        } catch (Throwable $e) {
            error_log('[adminPresentation] ' . $e->getMessage());
            $this->rediriger($slug, erreur: "Erreur technique : aucune modification n’a été enregistrée.");
        }

        $this->rediriger($slug, succes: 'Section mise à jour : ' . $section->getAdminTitle());
    }

    /**
     * Section "Réalisations & compétences" : 2 blocs (titre + intro),
     * une liste d'expériences et une liste de compétences.
     * Les lignes sont renumérotées 1..N dans l'ordre affiché.
     */
    private function enregistrerParcours(int $sectionId): void
    {
        $col1Title = $this->champ('col1_title');
        $col1Intro = $this->champ('col1_intro');
        $col3Title = $this->champ('col3_title');
        $col3Intro = $this->champ('col3_intro');

        if ($col1Title === '' || $col1Intro === '' || $col3Title === '' || $col3Intro === '') {
            throw new InvalidArgumentException('Les titres + intros des 2 blocs sont obligatoires.');
        }

        // Lignes non vides uniquement, dans l'ordre reçu
        $experiences = $this->lignes('timeline', ['title', 'desc', 'date']);
        $competences = $this->lignes('edu', ['title', 'desc', 'level']);

        $this->enTransaction(function () use ($sectionId, $col1Title, $col1Intro, $col3Title, $col3Intro, $experiences, $competences) {

            $this->contentBlockModel->updateBySectionSlot($sectionId, 'col1_title', ['text' => $col1Title]);
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'col1_intro', ['text' => $col1Intro]);
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'col3_title', ['text' => $col3Title]);
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'col3_intro', ['text' => $col3Intro]);

            // On désactive les anciennes lignes, puis on réactive celles envoyées
            $this->contentBlockModel->disableBySectionSlotPrefix($sectionId, 'timeline_');
            $this->contentBlockModel->disableBySectionSlotPrefix($sectionId, 'edu_');

            foreach ($experiences as $n => $ligne) {
                $ordre = 100 + ($n * 10);
                $this->ecrireLigne($sectionId, "timeline_{$n}", $ordre, [
                    'title' => ['span', $ligne['title']],
                    'desc'  => ['p',    $ligne['desc']],
                    'date'  => ['span', $ligne['date']],
                ]);
            }

            foreach ($competences as $n => $ligne) {
                $ordre = 500 + ($n * 10);
                $this->ecrireLigne($sectionId, "edu_{$n}", $ordre, [
                    'title' => ['span', $ligne['title']],
                    'desc'  => ['p',    $ligne['desc']],
                    'level' => ['span', $ligne['level']],
                ]);
            }
        });
    }

    /* ============================================================
       OUTILS
       ============================================================ */

    /** Lit $_POST[$nom][...][$champs], ignore les lignes vides, renumérote 1..N. */
    private function lignes(string $nom, array $champs): array
    {
        $resultat = [];
        $n = 0;

        foreach ((array) ($_POST[$nom] ?? []) as $ligne) {
            if (!is_array($ligne)) {
                continue;
            }

            $valeurs = [];
            foreach ($champs as $champ) {
                $valeurs[$champ] = trim((string) ($ligne[$champ] ?? ''));
            }

            if (implode('', $valeurs) === '') {
                continue;   // ligne entièrement vide : ignorée
            }

            $resultat[++$n] = $valeurs;
        }

        return $resultat;
    }

    /** Écrit les blocs d'une ligne : prefixe_title, prefixe_desc… */
    private function ecrireLigne(int $sectionId, string $prefixe, int $ordre, array $blocs): void
    {
        $i = 0;
        foreach ($blocs as $suffixe => [$type, $texte]) {
            $this->contentBlockModel->upsertBySectionSlot($sectionId, "{$prefixe}_{$suffixe}", [
                'type' => $type, 'text' => $texte, 'order_index' => $ordre + $i++, 'is_active' => 1,
            ]);
        }
    }

    private function enTransaction(callable $operations): void
    {
        $this->pdo->beginTransaction();
        try {
            $operations();
            $this->pdo->commit();
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    private function champ(string $nom): string
    {
        return trim((string) ($_POST[$nom] ?? ''));
    }

    private function trouverSection(array $sections, string $slug): ?Section
    {
        foreach ($sections as $s) {
            if ($s->getSlug() === trim($slug)) {
                return $s;
            }
        }
        return null;
    }

    private function rediriger(string $slug, ?string $erreur = null, ?string $succes = null): never
    {
        if ($erreur !== null) {
            $_SESSION['flashError'] = $erreur;
        }
        if ($succes !== null) {
            $_SESSION['flashSuccess'] = $succes;
        }

        $url = 'index.php?page=adminPresentation' . ($slug !== '' ? '&section=' . urlencode($slug) : '');
        header('Location: ' . $url);
        exit;
    }
}