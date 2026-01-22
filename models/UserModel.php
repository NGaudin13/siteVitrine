<?php

class UserModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find(int $id): ?User
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->hydrate($data);
    }

    public function save(User $user): void
    {
        $sql = "
            UPDATE user SET
                username = :username,
                company_name = :company_name,
                email = :email,
                phone = :phone,
                address = :address,
                updated_at = NOW()
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'username' => $user->getUsername(),
            'company_name'  => $user->getCompanyName(),
            'email'    => $user->getEmail(),
            'phone'    => $user->getPhone(),
            'address'  => $user->getAddress(),
            'id'       => $user->getId(),
        ]);
    }

    private function hydrate(array $data): User
    {
        $user = new User();

        // Hydratation manuelle (clean & explicite)
        $ref = new ReflectionClass($user);

        foreach ($data as $key => $value) {
            if ($ref->hasProperty($key)) {
                $property = $ref->getProperty($key);
                $property->setAccessible(true);
                $property->setValue($user, $value);
            }
        }

        return $user;
    }
}
