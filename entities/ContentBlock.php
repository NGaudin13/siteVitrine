<?php

class ContentBlock
{
    private int $id;
    private int $section_id;
    private string $type;          // enum en BDD, mais string en PHP
    private ?string $slot = null;

    private ?string $text = null;
    private ?string $src = null;
    private ?string $alt = null;
    private ?string $href = null;

    private int $order_index = 10;
    private bool $is_active = true;

    private ?string $created_at = null;
    private ?string $updated_at = null;

    /* ================== GETTERS ================== */

    public function getId(): int
    {
        return $this->id;
    }

    public function getSectionId(): int
    {
        return $this->section_id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getSlot(): ?string
    {
        return $this->slot;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getSrc(): ?string
    {
        return $this->src;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function getHref(): ?string
    {
        return $this->href;
    }

    public function getOrderIndex(): int
    {
        return $this->order_index;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    /* ================== SETTERS ================== */
    /* On met surtout ceux utiles au back-office */

    public function setType(string $type): self
    {
        $this->type = trim($type);
        return $this;
    }

    public function setSlot(?string $slot): self
    {
        $slot = $slot !== null ? trim($slot) : null;
        $this->slot = ($slot === '') ? null : $slot;
        return $this;
    }

    public function setText(?string $text): self
    {
        $text = $text !== null ? trim($text) : null;
        $this->text = ($text === '') ? null : $text;
        return $this;
    }

    public function setSrc(?string $src): self
    {
        $src = $src !== null ? trim($src) : null;
        $this->src = ($src === '') ? null : $src;
        return $this;
    }

    public function setAlt(?string $alt): self
    {
        $alt = $alt !== null ? trim($alt) : null;
        $this->alt = ($alt === '') ? null : $alt;
        return $this;
    }

    public function setHref(?string $href): self
    {
        $href = $href !== null ? trim($href) : null;
        $this->href = ($href === '') ? null : $href;
        return $this;
    }

    public function setOrderIndex(int $orderIndex): self
    {
        $this->order_index = $orderIndex;
        return $this;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->is_active = $isActive;
        return $this;
    }
}
