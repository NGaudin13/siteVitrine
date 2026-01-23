<?php

require_once PATH_MODELS . 'PageModel.php';
require_once PATH_MODELS . 'SectionModel.php';

class AdminAccueilController
{
    private PageModel $pageModel;
    private SectionModel $sectionModel;

    public function __construct(PDO $pdo)
    {
        $this->pageModel = new PageModel($pdo);
        $this->sectionModel = new SectionModel($pdo);
    }

    public function index(): void
    {
        $errors = [];
        $flashSuccess = null;

        // 1) Charger la page "accueil"
        $page = $this->pageModel->findBySlug('accueil');

        if (!$page) {
            http_response_code(404);
            echo "Page 'accueil' introuvable";
            return;
        }

        // 2) Charger les sections de la page accueil
        $sections = $this->sectionModel->findByPageId($page->getId(), true);

        // 3) Render vue
        require PATH_VIEWS_ADMIN . 'adminAccueil.php';
    }
}
