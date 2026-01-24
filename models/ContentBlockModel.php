<?php

require_once PATH_ENTITY . 'ContentBlock.php';

class ContentBlockModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find(int $id): ?ContentBlock
    {
        $stmt = $this->pdo->prepare("SELECT * FROM content_block WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->hydrate($data);
    }

    /**
     * Récupère tous les blocs d'une section (section_id)
     */
    public function findBySectionId(int $sectionId, bool $onlyActive = true): array
    {
        $sql = "SELECT * FROM content_block WHERE section_id = :sid";
        if ($onlyActive) {
            $sql .= " AND is_active = 1";
        }
        $sql .= " ORDER BY order_index ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['sid' => $sectionId]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $blocks = [];
        foreach ($rows as $row) {
            $blocks[] = $this->hydrate($row);
        }

        return $blocks;
    }

    /**
     * Version pratique: retourne les blocs indexés par slot
     * ex: $blocks['title'], $blocks['text_1'], etc.
     */
    public function findBySectionIdIndexedBySlot(int $sectionId, bool $onlyActive = true): array
    {
        $list = $this->findBySectionId($sectionId, $onlyActive);

        $out = [];
        foreach ($list as $block) {
            $slot = $block->getSlot();
            if ($slot !== null && $slot !== '') {
                $out[$slot] = $block;
            }
        }

        return $out;
    }

    public function save(ContentBlock $block): void
    {
        $sql = "
            UPDATE content_block SET
                type = :type,
                slot = :slot,
                text = :text,
                src = :src,
                alt = :alt,
                href = :href,
                order_index = :order_index,
                is_active = :is_active,
                updated_at = NOW()
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'type'        => $block->getType(),
            'slot'        => $block->getSlot(),
            'text'        => $block->getText(),
            'src'         => $block->getSrc(),
            'alt'         => $block->getAlt(),
            'href'        => $block->getHref(),
            'order_index' => $block->getOrderIndex(),
            'is_active'   => $block->isActive() ? 1 : 0,
            'id'          => $block->getId(),
        ]);
    }

    /**
     * Update rapide d'un bloc via (section_id + slot) => utile pour back-office simple
     */
    public function updateBySectionSlot(int $sectionId, string $slot, array $fields): void
    {
        $allowed = ['text', 'src', 'alt', 'href', 'type', 'order_index', 'is_active'];
        $setParts = [];
        $params = ['sid' => $sectionId, 'slot' => $slot];

        foreach ($fields as $k => $v) {
            if (in_array($k, $allowed, true)) {
                $setParts[] = "{$k} = :{$k}";
                $params[$k] = $v;
            }
        }

        if (empty($setParts)) {
            return;
        }

        $sql = "UPDATE content_block
                SET " . implode(', ', $setParts) . ", updated_at = NOW()
                WHERE section_id = :sid AND slot = :slot
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    private function hydrate(array $data): ContentBlock
    {
        $block = new ContentBlock();
        $ref   = new ReflectionClass($block);

        foreach ($data as $key => $value) {

            // Casts
            if (in_array($key, ['id', 'section_id', 'order_index'], true)) {
                $value = (int)$value;
            }
            if ($key === 'is_active') {
                $value = (bool)$value;
            }

            if ($ref->hasProperty($key)) {
                $property = $ref->getProperty($key);
                $property->setAccessible(true);
                $property->setValue($block, $value);
            }
        }

        return $block;
    }

        /**
     * Désactive tous les blocs d'une section dont le slot commence par un préfixe
     * ex: "timeline_" ou "edu_"
     */
    public function deactivateBySlotPrefix(int $sectionId, string $prefix): void
    {
        $sql = "UPDATE content_block
                SET is_active = 0, updated_at = NOW()
                WHERE section_id = :sid
                AND slot LIKE :pref";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'sid'  => $sectionId,
            'pref' => $prefix . '%',
        ]);
    }

    /**
     * Upsert texte: update si existe, sinon insert
     * (utile quand l'admin ajoute une ligne via +)
     */
    public function upsertTextBlock(int $sectionId, string $type, string $slot, string $text, int $orderIndex, bool $isActive = true): void
    {
        // 1) update
        $sqlUpdate = "UPDATE content_block
                    SET type = :type,
                        text = :text,
                        order_index = :order_index,
                        is_active = :is_active,
                        updated_at = NOW()
                    WHERE section_id = :sid AND slot = :slot
                    LIMIT 1";
        $stmt = $this->pdo->prepare($sqlUpdate);
        $stmt->execute([
            'type'        => $type,
            'text'        => $text,
            'order_index' => $orderIndex,
            'is_active'   => $isActive ? 1 : 0,
            'sid'         => $sectionId,
            'slot'        => $slot,
        ]);

        if ($stmt->rowCount() > 0) {
            return;
        }

        // 2) insert
        $sqlInsert = "INSERT INTO content_block
            (section_id, type, slot, text, src, alt, href, order_index, is_active, created_at, updated_at)
            VALUES
            (:sid, :type, :slot, :text, NULL, NULL, NULL, :order_index, :is_active, NOW(), NOW())";
        $stmt2 = $this->pdo->prepare($sqlInsert);
        $stmt2->execute([
            'sid'         => $sectionId,
            'type'        => $type,
            'slot'        => $slot,
            'text'        => $text,
            'order_index' => $orderIndex,
            'is_active'   => $isActive ? 1 : 0,
        ]);
    }

    public function disableBySectionSlotPrefix(int $sectionId, string $prefix): void
    {
        $sql = "UPDATE content_block
                SET is_active = 0, updated_at = NOW()
                WHERE section_id = :sid AND slot LIKE :pfx";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'sid' => $sectionId,
            'pfx' => $prefix . '%'
        ]);
    }

    public function upsertBySectionSlot(int $sectionId, string $slot, array $fields): void
    {
        // Si existe -> update, sinon -> insert
        $stmt = $this->pdo->prepare("SELECT id FROM content_block WHERE section_id = :sid AND slot = :slot LIMIT 1");
        $stmt->execute(['sid' => $sectionId, 'slot' => $slot]);
        $id = $stmt->fetchColumn();

        $defaults = [
            'type' => 'p',
            'text' => null,
            'src' => null,
            'alt' => null,
            'href' => null,
            'order_index' => 0,
            'is_active' => 1
        ];
        $data = array_merge($defaults, $fields);

        if ($id) {
            // update
            $sql = "UPDATE content_block SET
                        type = :type,
                        text = :text,
                        src = :src,
                        alt = :alt,
                        href = :href,
                        order_index = :order_index,
                        is_active = :is_active,
                        updated_at = NOW()
                    WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'type' => $data['type'],
                'text' => $data['text'],
                'src'  => $data['src'],
                'alt'  => $data['alt'],
                'href' => $data['href'],
                'order_index' => (int)$data['order_index'],
                'is_active'   => (int)$data['is_active'],
                'id' => (int)$id
            ]);
            return;
        }

        // insert
        $sql = "INSERT INTO content_block (section_id, type, slot, text, src, alt, href, order_index, is_active, created_at, updated_at)
                VALUES (:sid, :type, :slot, :text, :src, :alt, :href, :order_index, :is_active, NOW(), NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'sid' => $sectionId,
            'type' => $data['type'],
            'slot' => $slot,
            'text' => $data['text'],
            'src'  => $data['src'],
            'alt'  => $data['alt'],
            'href' => $data['href'],
            'order_index' => (int)$data['order_index'],
            'is_active'   => (int)$data['is_active'],
        ]);
    }

}
