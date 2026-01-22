<?php

class User
{
    private int $id;
    private int $roleId;
    private string $username;
    private string $email;
    private ?string $phone;
    private ?string $address;
    private bool $isActive;
    private string $company_name;
    private ?string $opening_hours;
    private ?string $response_delay;
    private ?string $createdAt;
    private ?string $updatedAt;

    /* ================== GETTERS ================== */

    public function getId(): int
    {
        return $this->id;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getCompanyName(): string
    {
        return $this->company_name;
    }

    public function getOpeningHours(): ?string
    {
        return $this->opening_hours;
    }

    public function getResponseDelay(): ?string
    {
        return $this->response_delay;
    }


    /* ================== SETTERS ================== */

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->company_name = strtoupper($companyName);
        return $this;
    }

    public function setOpeningHours(?string $openingHours): self
    {
        $this->opening_hours = $openingHours;
        return $this;
    }

    public function setResponseDelay(?string $responseDelay): self
    {
        $this->response_delay = $responseDelay;
        return $this;
    }
    
}
