<?php
// =========================================================
// FICHIER : siteVitrine/controllers/adminContactController.php
// Back-office : sujets proposés dans le formulaire de contact.
//
// Même règle que l'accueil : on valide tout, puis on écrit
// en base dans UNE transaction (tout ou rien).
// =========================================================

require_once PATH_MODELS . 'PageModel.php';
require_once PATH_MODELS . 'SectionModel.php';
require_once PATH_MODELS . 'ContentBlockModel.php';

class AdminContactController
{
    /** Le slot fait 60 caractères max en base : "subject_" (8) + valeur (50 max) */
    private const VALEUR_MAX = 50;

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

        // 1) PAGE CONTACT
        $page = $this->pageModel->findBySlug('contact');
        if (!$page) {
            http_response_code(404);
            return ['flashError' => "Page 'contact' introuvable.", 'sections' => []];
        }

        // 2) SECTIONS
        $sections = $this->sectionModel->findByPageId((int) $page->getId(), true);
        if (empty($sections)) {
            http_response_code(404);
            return ['flashError' => "Aucune section trouvée pour la page 'contact'.", 'sections' => []];
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
                'contact-nature-demande' => $this->enregistrerSujets($sectionId),
                default                  => throw new InvalidArgumentException("Section non gérée : {$slug}"),
            };
        } catch (InvalidArgumentException $e) {
            $this->rediriger($slug, erreur: $e->getMessage());
        } catch (Throwable $e) {
            error_log('[adminContact] ' . $e->getMessage());
            $this->rediriger($slug, erreur: "Erreur technique : aucune modification n’a été enregistrée.");
        }

        $this->rediriger($slug, succes: 'Section mise à jour : ' . $section->getAdminTitle());
    }

    /**
     * Sujets du formulaire de contact.
     * Attend : subjects[i][label], subjects[i][value], subjects[i][active]
     * L'ordre d'affichage = l'ordre reçu (réglé avec ↑ ↓ dans l'admin).
     */
    private function enregistrerSujets(int $sectionId): void
    {
        // ---------- 1) Validation complète AVANT toute écriture
        $sujets = [];

        foreach ((array) ($_POST['subjects'] ?? []) as $ligne) {
            if (!is_array($ligne)) {
                continue;
            }

            $libelle = trim((string) ($ligne['label'] ?? ''));
            $valeur  = trim((string) ($ligne['value'] ?? ''));

            if ($libelle === '' && $valeur === '') {
                continue;
            }

            // Valeur technique : fournie par l'admin, sinon déduite du libellé
            $valeur = $this->slugify($valeur !== '' ? $valeur : $libelle);
            $valeur = substr($valeur, 0, self::VALEUR_MAX);

            if ($valeur === '') {
                continue;
            }

            // Deux libellés qui donnent la même valeur : on garde le premier
            if (isset($sujets[$valeur])) {
                continue;
            }

            $sujets[$valeur] = [
                'label'  => $libelle !== '' ? $libelle : $valeur,
                'active' => isset($ligne['active']) ? 1 : 0,
            ];
        }

        // Correction de bug : avant, tous les sujets étaient désactivés
        // AVANT ce contrôle, ce qui vidait la liste du formulaire public.
        if (empty($sujets)) {
            throw new InvalidArgumentException('Ajoutez au moins un sujet.');
        }

        // ---------- 2) Écriture en base : tout ou rien
        $this->enTransaction(function () use ($sectionId, $sujets) {

            $this->contentBlockModel->disableBySectionSlotPrefix($sectionId, 'subject_');

            $n = 0;
            foreach ($sujets as $valeur => $sujet) {
                $this->contentBlockModel->upsertBySectionSlot($sectionId, 'subject_' . $valeur, [
                    'type'        => 'p',
                    'text'        => $sujet['label'],
                    'order_index' => (++$n) * 10,
                    'is_active'   => $sujet['active'],
                ]);
            }
        });
    }

    /* ============================================================
       OUTILS
       ============================================================ */

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

    /**
     * "Étude spécifique" -> "etude-specifique"
     *
     * On n'utilise PAS iconv('ASCII//TRANSLIT') : sous Windows (XAMPP)
     * il supprime les lettres accentuées au lieu de les remplacer
     * ("tude-sp-cifique"). Table de correspondance = même résultat partout.
     */
    private function slugify(string $texte): string
    {
        static $accents = [
            'à' => 'a', 'â' => 'a', 'ä' => 'a', 'á' => 'a', 'ã' => 'a', 'å' => 'a',
            'ç' => 'c',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'î' => 'i', 'ï' => 'i', 'í' => 'i', 'ì' => 'i',
            'ô' => 'o', 'ö' => 'o', 'ó' => 'o', 'ò' => 'o', 'õ' => 'o',
            'ù' => 'u', 'û' => 'u', 'ü' => 'u', 'ú' => 'u',
            'ÿ' => 'y', 'ñ' => 'n', 'œ' => 'oe', 'æ' => 'ae',
        ];

        $texte = mb_strtolower(trim($texte), 'UTF-8');
        $texte = strtr($texte, $accents);
        $texte = (string) preg_replace('/[^a-z0-9]+/', '-', $texte);

        return trim($texte, '-');
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

        $url = 'index.php?page=adminContact' . ($slug !== '' ? '&section=' . urlencode($slug) : '');
        header('Location: ' . $url);
        exit;
    }
}