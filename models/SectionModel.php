<?php

require_once PATH_ENTITY . 'Section.php';

class SectionModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find(int $id): ?Section
    {
        $stmt = $this->pdo->prepare("SELECT * FROM section WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->hydrate($data);
    }

    /**
     * Récupère toutes les sections d'une page (par page_id)
     */
    public function findByPageId(int $pageId, bool $onlyActive = true): array
    {
        $sql = "SELECT * FROM section WHERE page_id = :pid";
        if ($onlyActive) {
            $sql .= " AND is_active = 1";
        }
        $sql .= " ORDER BY order_index ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['pid' => $pageId]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sections = [];
        foreach ($rows as $row) {
            $sections[] = $this->hydrate($row);
        }

        return $sections;
    }

    public function save(Section $section): void
    {
        $sql = "
            UPDATE section SET
                slug = :slug,
                admin_title = :admin_title,
                template = :template,
                order_index = :order_index,
                is_active = :is_active,
                updated_at = NOW()
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'slug'        => $section->getSlug(),
            'admin_title' => $section->getAdminTitle(),
            'template'    => $section->getTemplate(),
            'order_index' => $section->getOrderIndex(),
            'is_active'   => $section->isActive() ? 1 : 0,
            'id'          => $section->getId(),
        ]);
    }

    private function hydrate(array $data): Section
    {
        $section = new Section();
        $ref     = new ReflectionClass($section);

        foreach ($data as $key => $value) {

            // Casts
            if (in_array($key, ['id', 'page_id', 'order_index'], true)) {
                $value = (int)$value;
            }
            if ($key === 'is_active') {
                $value = (bool)$value;
            }

            if ($ref->hasProperty($key)) {
                $property = $ref->getProperty($key);
                $property->setAccessible(true);
                $property->setValue($section, $value);
            }
        }

        return $section;
    }
}
