<?php

namespace App\Repository;

use App\ValueObject\UUID;
use src\User;

class UserRepositoryInterface
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(User $user): void
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO users (uuid, name, surname, username)
             VALUES (:uuid, :name, :surname, :username)'
        );

        $statement->execute([
            'uuid'     => (string)$user->getUuid(),
            'name'     => $user->getName(),
            'surname'  => $user->getSurname(),
            'username' => $user->getUsername(),
        ]);
    }

    public function get(UUID $uuid): User
    {
        $statement = $this->pdo->prepare(
            'SELECT * FROM users WHERE uuid = :uuid'
        );

        $statement->execute([
            'uuid' => (string)$uuid
        ]);

        $userData = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            throw new NotFoundException('User not found');
        }

        return new User(
            new UUID($userData['uuid']),
            $userData['name'],
            $userData['surname'],
            $userData['username']
        );
    }
}
