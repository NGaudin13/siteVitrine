<?php

require_once PATH_ENTITY . 'Page.php';

class PageModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find(int $id): ?Page
    {
        $stmt = $this->pdo->prepare("SELECT * FROM page WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->hydrate($data);
    }

    public function findBySlug(string $slug): ?Page
    {
        $stmt = $this->pdo->prepare("SELECT * FROM page WHERE slug = :slug LIMIT 1");
        $stmt->execute(['slug' => $slug]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->hydrate($data);
    }

    public function save(Page $page): void
    {
        $sql = "
            UPDATE page SET
                slug = :slug,
                title = :title,
                meta_title = :meta_title,
                meta_desc = :meta_desc,
                canonical = :canonical,
                is_active = :is_active,
                updated_at = NOW()
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'slug'       => $page->getSlug(),
            'title'      => $page->getTitle(),
            'meta_title' => $page->getMetaTitle(),
            'meta_desc'  => $page->getMetaDesc(),
            'canonical'  => $page->getCanonical(),
            'is_active'  => $page->isActive() ? 1 : 0,
            'id'         => $page->getId(),
        ]);
    }

    private function hydrate(array $data): Page
    {
        $page = new Page();
        $ref  = new ReflectionClass($page);

        foreach ($data as $key => $value) {

            // Casts
            if ($key === 'id') {
                $value = (int)$value;
            }
            if ($key === 'is_active') {
                $value = (bool)$value;
            }

            // Hydrate
            if ($ref->hasProperty($key)) {
                $property = $ref->getProperty($key);
                $property->setAccessible(true);
                $property->setValue($page, $value);
            }
        }

        return $page;
    }
}
