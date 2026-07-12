<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class UserRepository
{
    public function __construct(
        private readonly PDO $database,
    ) {
    }

    public function findByEmail(string $email): ?array
    {
        $statement = $this->database->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $statement->execute(['email' => $email]);
        $user = $statement->fetch();

        return is_array($user) ? $user : null;
    }

    public function findById(int $id): ?array
    {
        $statement = $this->database->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        $user = $statement->fetch();

        return is_array($user) ? $user : null;
    }

    public function create(string $name, string $email, string $passwordHash): int
    {
        $statement = $this->database->prepare(
            'INSERT INTO users (name, email, password_hash, created_at, updated_at)
             VALUES (:name, :email, :password_hash, :created_at, :updated_at)'
        );

        $timestamp = date('Y-m-d H:i:s');
        $statement->execute([
            'name' => $name,
            'email' => $email,
            'password_hash' => $passwordHash,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        return (int) $this->database->lastInsertId();
    }
}
