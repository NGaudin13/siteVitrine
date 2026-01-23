<?php

require_once PATH_ENTITY . 'User.php';

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
                opening_hours = :opening_hours,
                response_delay = :response_delay,
                updated_at = NOW()
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        error_log('POST opening_hours=' . ($_POST['opening_hours'] ?? 'MISSING'));
error_log('POST response_delay=' . ($_POST['response_delay'] ?? 'MISSING'));

error_log('OBJ opening_hours=' . var_export($user->getOpeningHours(), true));
error_log('OBJ response_delay=' . var_export($user->getResponseDelay(), true));

        $stmt->execute([
            'username' => $user->getUsername(),
            'company_name'  => $user->getCompanyName(),
            'email'    => $user->getEmail(),
            'phone'    => $user->getPhone(),
            'address'  => $user->getAddress(),
            'opening_hours'   => $user->getOpeningHours(),
            'response_delay'  => $user->getResponseDelay(),
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
