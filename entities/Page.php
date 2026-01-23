<?php

class Page
{
    private int $id;
    private string $slug;
    private string $title;
    private ?string $meta_title = null;
    private ?string $meta_desc = null;
    private ?string $canonical = null;
    private bool $is_active = true;
    private ?string $created_at = null;
    private ?string $updated_at = null;

    /* ================== GETTERS ================== */

    public function getId(): int
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getMetaTitle(): ?string
    {
        return $this->meta_title;
    }

    public function getMetaDesc(): ?string
    {
        return $this->meta_desc;
    }

    public function getCanonical(): ?string
    {
        return $this->canonical;
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

    public function setTitle(string $title): self
    {
        $this->title = trim($title);
        return $this;
    }

    public function setMetaTitle(?string $metaTitle): self
    {
        $metaTitle = $metaTitle !== null ? trim($metaTitle) : null;
        $this->meta_title = ($metaTitle === '') ? null : $metaTitle;
        return $this;
    }

    public function setMetaDesc(?string $metaDesc): self
    {
        $metaDesc = $metaDesc !== null ? trim($metaDesc) : null;
        $this->meta_desc = ($metaDesc === '') ? null : $metaDesc;
        return $this;
    }

    public function setCanonical(?string $canonical): self
    {
        $canonical = $canonical !== null ? trim($canonical) : null;
        $this->canonical = ($canonical === '') ? null : $canonical;
        return $this;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->is_active = $isActive;
        return $this;
    }
}
