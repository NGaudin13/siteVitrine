<?php

class Section
{
    private int $id;
    private int $page_id;
    private string $slug;
    private string $admin_title;
    private ?string $template = null;
    private int $order_index = 10;
    private bool $is_active = true;
    private ?string $created_at = null;
    private ?string $updated_at = null;

    /* ================== GETTERS ================== */

    public function getId(): int
    {
        return $this->id;
    }

    public function getPageId(): int
    {
        return $this->page_id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getAdminTitle(): string
    {
        return $this->admin_title;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
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

    public function setSlug(string $slug): self
    {
        $this->slug = trim($slug);
        return $this;
    }

    public function setAdminTitle(string $adminTitle): self
    {
        $this->admin_title = trim($adminTitle);
        return $this;
    }

    public function setTemplate(?string $template): self
    {
        $template = $template !== null ? trim($template) : null;
        $this->template = ($template === '') ? null : $template;
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
