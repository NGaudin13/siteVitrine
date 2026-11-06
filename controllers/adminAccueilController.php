<?php
// =========================================================
// FICHIER : siteVitrine/controllers/adminAccueilController.php
// Back-office : édition des sections de la page Accueil.
//
// Règle de fiabilité (étape 5) :
//   1) on VALIDE tout ce qui a été envoyé
//   2) on enregistre les éventuelles images
//   3) on écrit en base dans UNE transaction : tout ou rien.
// Une erreur ne laisse donc jamais la page à moitié modifiée.
// =========================================================

require_once PATH_MODELS . 'PageModel.php';
require_once PATH_MODELS . 'SectionModel.php';
require_once PATH_MODELS . 'ContentBlockModel.php';
require_once PATH_LIB . 'ImageUpload.php';

class AdminAccueilController
{
    /** Nombre maximum de cartes "domaines d'intervention" */
    private const MAX_DOMAINES = 9;

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
        // ===================== FLASH =====================
        $flashSuccess = $_SESSION['flashSuccess'] ?? null;
        $flashError   = $_SESSION['flashError'] ?? null;
        unset($_SESSION['flashSuccess'], $_SESSION['flashError']);

        // ===================== 1) PAGE ACCUEIL =====================
        $page = $this->pageModel->findBySlug('accueil');
        if (!$page) {
            http_response_code(404);
            return ['flashError' => "Page 'accueil' introuvable.", 'sections' => []];
        }

        // ===================== 2) SECTIONS =====================
        $sections = $this->sectionModel->findByPageId((int) $page->getId(), true);
        if (empty($sections)) {
            http_response_code(404);
            return ['flashError' => "Aucune section trouvée pour la page 'accueil'.", 'sections' => []];
        }

        // ===================== 3) POST : SAUVEGARDE =====================
        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
            $this->enregistrer($sections);   // redirige toujours (pas de retour)
        }

        // ===================== 4) SECTION SÉLECTIONNÉE =====================
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

            // Compatibilité avec d'anciennes vues
            'blockTitle'      => $blocks['title']  ?? null,
            'blockP1'         => $blocks['text_1'] ?? null,
            'blockP2'         => $blocks['text_2'] ?? null,
            'blockImg'        => $blocks['image']  ?? null,
        ];
    }

    /* ============================================================
       ENREGISTREMENT
       ============================================================ */

    /** Traite le formulaire, puis redirige avec un message (succès ou erreur). */
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
                'home-intro'   => $this->enregistrerIntro($sectionId),
                'home-about'   => $this->enregistrerAPropos($sectionId),
                'home-domains' => $this->enregistrerDomaines($sectionId),
                default        => throw new InvalidArgumentException("Section non gérée : {$slug}"),
            };
        } catch (InvalidArgumentException $e) {
            // Erreur de saisie : message clair, rien n'a été écrit
            $this->rediriger($slug, erreur: $e->getMessage());
        } catch (Throwable $e) {
            // Erreur technique : détail dans les logs, rien n'a été écrit (rollback)
            error_log('[adminAccueil] ' . $e->getMessage());
            $this->rediriger($slug, erreur: "Erreur technique : aucune modification n’a été enregistrée.");
        }

        $this->rediriger($slug, succes: 'Section mise à jour : ' . $section->getAdminTitle());
    }

    /** Section "Le BIM" : titre + 2 paragraphes + image */
    private function enregistrerIntro(int $sectionId): void
    {
        $title = $this->champ('title');
        $text1 = $this->champ('text_1');
        $text2 = $this->champ('text_2');

        if ($title === '' || $text1 === '' || $text2 === '') {
            throw new InvalidArgumentException('Titre + paragraphe 1 + paragraphe 2 obligatoires.');
        }

        [$src, $alt] = $this->imageUnique('home-intro');

        $this->enTransaction(function () use ($sectionId, $title, $text1, $text2, $src, $alt) {
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'title',  ['text' => $title]);
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'text_1', ['text' => $text1]);
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'text_2', ['text' => $text2]);
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'image',  ['src' => $src, 'alt' => $alt]);
        });
    }

    /** Section "À propos" : titre + paragraphe + 2 statistiques + image */
    private function enregistrerAPropos(int $sectionId): void
    {
        $title = $this->champ('title');
        $text1 = $this->champ('text_1');
        $stat1 = $this->champ('stat_1_value');
        $stat2 = $this->champ('stat_2_value');

        if ($title === '' || $text1 === '') {
            throw new InvalidArgumentException('Titre + paragraphe obligatoires.');
        }
        if ($stat1 === '' || $stat2 === '') {
            throw new InvalidArgumentException('Les 2 statistiques sont obligatoires (ex : 45+ et 100%).');
        }

        [$src, $alt] = $this->imageUnique('home-about');

        $this->enTransaction(function () use ($sectionId, $title, $text1, $stat1, $stat2, $src, $alt) {
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'title',        ['text' => $title]);
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'text_1',       ['text' => $text1]);
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'stat_1_value', ['text' => $stat1]);
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'stat_2_value', ['text' => $stat2]);
            $this->contentBlockModel->updateBySectionSlot($sectionId, 'image',        ['src' => $src, 'alt' => $alt]);
        });
    }

    /**
     * Section "Domaines d'intervention" : titre + intro + jusqu'à 9 cartes.
     *
     * Les cartes sont renumérotées dans l'ORDRE AFFICHÉ dans l'admin
     * (domain_1 = première carte, etc.) : le site public respecte donc
     * l'ordre choisi avec les flèches ↑ ↓.
     */
    private function enregistrerDomaines(int $sectionId): void
    {
        $title = $this->champ('title');
        $intro = $this->champ('intro');

        if ($title === '' || $intro === '') {
            throw new InvalidArgumentException('Titre + intro obligatoires.');
        }

        $lignes = $_POST['domains'] ?? [];
        if (!is_array($lignes)) {
            $lignes = [];
        }
        if (count($lignes) > self::MAX_DOMAINES) {
            throw new InvalidArgumentException('Maximum ' . self::MAX_DOMAINES . ' domaines.');
        }

        // ---------- 1) Validation de TOUTES les cartes avant d'écrire quoi que ce soit
        $cartes   = [];
        $position = 0;

        foreach ($lignes as $cleFormulaire => $ligne) {
            $position++;
            $carte = [
                'title'   => trim((string) ($ligne['title'] ?? '')),
                'desc'    => trim((string) ($ligne['desc'] ?? '')),
                'alt'     => trim((string) ($ligne['alt'] ?? '')),
                'src'     => trim((string) ($ligne['image_src'] ?? '')),
                'fichier' => ImageUpload::depuisTableauMultiple('domains', $cleFormulaire, 'image_file'),
            ];

            if ($carte['title'] === '' || $carte['desc'] === '' || $carte['alt'] === '') {
                throw new InvalidArgumentException("Titre + description + alt obligatoires (domaine n°{$position}).");
            }
            if ($carte['fichier']) {
                ImageUpload::verifier($carte['fichier'], " (domaine n°{$position})");
            } elseif ($carte['src'] === '') {
                throw new InvalidArgumentException("Image obligatoire : chargez une image (domaine n°{$position}).");
            }

            $cartes[$position] = $carte;
        }

        // ---------- 2) Enregistrement des nouvelles images (tout est valide)
        foreach ($cartes as $position => $carte) {
            if ($carte['fichier']) {
                $cartes[$position]['src'] = ImageUpload::enregistrer($carte['fichier'], "accueil_home-domains_{$position}");
            }
        }

        // ---------- 3) Écriture en base : tout ou rien
        $this->enTransaction(function () use ($sectionId, $title, $intro, $cartes) {

            $this->contentBlockModel->upsertBySectionSlot($sectionId, 'title', [
                'type' => 'h2', 'text' => $title, 'order_index' => 10, 'is_active' => 1,
            ]);
            $this->contentBlockModel->upsertBySectionSlot($sectionId, 'intro', [
                'type' => 'p', 'text' => $intro, 'order_index' => 20, 'is_active' => 1,
            ]);

            // On désactive toutes les cartes, puis on réactive celles envoyées
            // (une carte supprimée dans l'admin disparaît ainsi du site).
            $this->contentBlockModel->disableBySectionSlotPrefix($sectionId, 'domain_');

            foreach ($cartes as $n => $carte) {
                $ordre = 100 + ($n * 10);   // 110, 120, 130…

                $this->contentBlockModel->upsertBySectionSlot($sectionId, "domain_{$n}_title", [
                    'type' => 'h3', 'text' => $carte['title'], 'order_index' => $ordre, 'is_active' => 1,
                ]);
                $this->contentBlockModel->upsertBySectionSlot($sectionId, "domain_{$n}_desc", [
                    'type' => 'p', 'text' => $carte['desc'], 'order_index' => $ordre + 1, 'is_active' => 1,
                ]);
                $this->contentBlockModel->upsertBySectionSlot($sectionId, "domain_{$n}_img", [
                    'type' => 'img', 'src' => $carte['src'], 'alt' => $carte['alt'],
                    'order_index' => $ordre + 2, 'is_active' => 1,
                ]);
            }
        });
    }

    /* ============================================================
       OUTILS
       ============================================================ */

    /** Image unique d'une section : alt obligatoire, upload optionnel. Renvoie [src, alt]. */
    private function imageUnique(string $slug): array
    {
        $src = $this->champ('image_src');
        $alt = $this->champ('image_alt');

        if ($alt === '') {
            throw new InvalidArgumentException('Le texte alternatif (alt) est obligatoire.');
        }

        $fichier = ImageUpload::depuisChamp('image_file');

        if ($fichier) {
            ImageUpload::verifier($fichier);
            $src = ImageUpload::enregistrer($fichier, "accueil_{$slug}");
        }

        if ($src === '') {
            throw new InvalidArgumentException('Image obligatoire : chargez une image.');
        }

        return [$src, $alt];
    }

    /** Exécute $operations dans une transaction : tout est écrit, ou rien. */
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

        $url = 'index.php?page=adminAccueil' . ($slug !== '' ? '&section=' . urlencode($slug) : '');
        header('Location: ' . $url);
        exit;
    }
}